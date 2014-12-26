$(document).on('ready',function(){
	
	if ( $('#gmap').length > 0 )
	{
		
		$('.thumbs-inner,.jspPane').on('click','.thumb-block', function(){
			var el = $(this);
			$(document).find(".col-right #gmap").gmap3({
		      get: {
		        name:"marker",
		        all: true,
		        callback: function(objs){
		          $.each(objs, function(i, obj){
		        	console.log(obj.position);
		        	if ( el.data('longitude') == obj.position.B && el.data('latitude') == obj.position.k || el.data('longitude') == obj.position.A && el.data('latitude') == obj.position.k )
		        	{
		        		google.maps.event.trigger(objs[i], 'click');
		        	}
		          });
		        }
		      }
		    });
			
		});
		
	}
	
	if ( $('.thumbs').length > 0 )
	{
		// Paginator
		loadData(1,true); 
		
        $(document).on('click','.pagination li.active a',function(e){
        	e.preventDefault();
            var page = $(this).data('p');
            loadData(page);
        });
     
	}
	
});

function createMap(element, markers) {
	$(element).gmap3({
	    marker:{
			values: markers,
	    	options:{
				draggable: false
	    	},
		    events:{
				click: function(marker, event, context){
					$(this).gmap3({clear:"infowindow"});
					$(this).gmap3({
		                infowindow:{
		                	address : '',  
		                  	anchor  : marker,
		                  	options : {
			                	content: '<div class="infobox">' +
		             			'<div><img src="'+ context.data.image + '" class="marker-image" /></div>' +
					            '</div>'
						  }
		                }
		            });
					
		     	}
		    }
			}
		},"autofit");
};

function regenerateMap(element, markers)
{
	$(element).gmap3({
        action: 'destroy'
    });
	
	var container = $(element).parent();
    $(element).remove();
    container.append('<div id="gmap"></div>');
    
    createMap(element,markers);
}

function addScrollPane(element)
{
	$(element).jScrollPane({
        showArrows: false,
        autoReinitialise: false
	});
}

function loadData(page,init)
{     
	
    $.ajax({
		method : 'POST',
		url    : 'php/controller/fetch_pages.php',
		data   : { page : page },
		beforeSend: function(){
			$(".thumbs-inner").prepend('<div class="loading-indication"><img src="images/ajax-loader.gif" /> Cargando...</div>');
		},
		success : function(data)
		{
			setTimeout(function(){
				if ( init == true ) {
				
					$('.thumbs-inner').html(data).promise().done(function(){
						//markers
						var markers = [];
						$(document).find('.thumb-block').each(function(key,el){
							var imagen     = $(el).data('image');
							var latitude   = $(el).data('latitude');
							var longitude  = $(el).data('longitude');
							var id         = $(el).data('locationid');
							
							marker=[];
							
							marker.lat=latitude;
							marker.lng=longitude;
							marker.data = []; 
							marker.data.image = imagen;
							
							markers.push(marker);
							
						});
						
						regenerateMap('#gmap',markers);
						addScrollPane('.thumbs-inner');
					});
					
				} else {
					
					$(document).find('.loading-indication').remove();
					
					api = $(".thumbs-inner").data('jsp');
				    api.getContentPane().html(data).promise().done(function(){
						//markers
						var markers = [];
						$(document).find('.thumb-block').each(function(key,el){
							var imagen     = $(el).data('image');
							var latitude   = $(el).data('latitude');
							var longitude  = $(el).data('longitude');
							var id         = $(el).data('locationid');
							
							marker=[];
							
							marker.lat=latitude;
							marker.lng=longitude;
							marker.data = []; 
							marker.data.image = imagen;
							
							markers.push(marker);
							
						});
						
						regenerateMap('#gmap',markers);
					});
				    
				    api.reinitialise();
				}
			},1000);
		}
	});
    
}