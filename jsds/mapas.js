jQuery(function($) {});
$$_=jQuery.noConflict();
$$_(function($) {
	// Agrega la declaración de estilo al documento
    const style = document.createElement('style');
    style.type = 'text/css';
    style.innerHTML = `
    ul.nav span{cursor:pointer}
    ul.nav span:hover{font-weight:700}
    ul.nav ul{display:none}
    /*ul.nav li:hover ul{display:block}*/
    ul.nav ul li{line-height:1em}
    ul.nav ul.menuEtiqActivo{display:block}
    #planoTipos li{
        /*border-bottom:1px solid #ccc;
        border-left:1px solid #ccc;
        border-radius:.6em;*/
        border-top:4px solid #ccc;
        padding:0 .1em 0 .2em
    }
    .span9 .item_introtext{width:100%}
    `;
    document.head.appendChild(style);
 
    // Marca que el estilo del menú ha sido añadido
    window.estiloMenu = true;

	$('#imagenPlano').rwdImageMaps();
	idioma=$('html').attr('lang');
	cadenas={
		es:{
			numero:"<abbr title='Número'>Nº</abbr>",
			categoria:"Categoría",
			info:"Señale el puesto del que<br />desea más información"
		},
		eu:{
			numero:"<abbr title='Zenbakia'>Zb</abbr>",
			categoria:"Kategoria",
			info:"informazio gehiago"
		},
		fr:{
			numero:"<abbr title='Numéro'>Nº</abbr>",
			categoria:"Catégorie",
			info:"Marquez l'étal pour plus d'information"
		},
		en:{
			numero:"<abbr title='Number'>#</abbr>",
			categoria:"Category",
			info:"Mark the stall for more information"
		}
	}
	cadActual=eval("cadenas."+idioma.substr(0,2));
	$.fn.maphilight.defaults = {
		fill:true,
		fillOpacity: .5,
		stroke: true,
		strokeOpacity: 1
	}
		/*,
		fill: true,
		fillColor: '000000',
		fillOpacity: .2,
		stroke: true,
		strokeColor: 'ff0000',
		strokeOpacity: 1,
		strokeWidth: 1,
		fade: true,
		alwaysOn: false,
		neverOn: false,
		groupBy: false,
		wrapClass: true,
		shadow: false,
		shadowX: 0,
		shadowY: 0,
		shadowRadius: 6,
		shadowColor: '000000',
		shadowOpacity: .8,
		shadowPosition: 'outside',
		shadowFrom: false*/
	tipos=new Array();
	$("#plano-puestos").find("area").each(function(e) {
		tipoPto=$(this).data("tipo");
		if (!tipos.includes(tipoPto)) tipos.push(tipoPto);
		color=$("#ver"+$(this).data("tipo")).data("color");
		estilo={
			groupBy: "."+tipoPto,
			fillColor: color,
			fillOpacity: .5,
			strokeColor: color
		}
		$(this).data("maphilight",estilo);
		$(this).hover(function() {
			$("#imagenPlano").css("opacity",.5);
			$("#nombrePuesto").html(cadActual.numero+" "+$(this).data("num")+" - <strong>"+$(this).attr("title")+"</strong><br /><small>"+cadActual.categoria+": "+$("#ver"+$(this).data("tipo")).html()+"</small>");
			//$(this).attr("title","Ir a la ficha de: "+$(this).attr("title"));
		});
	});
	tipos.sort();
	
	// Inicializar mapa interactivo
	$('.mapa').maphilight();
	
	// Resaltar tipos
	cadTemp="";
	for (i=0; i<tipos.length; i++){
		if (typeof($("#ver"+tipos[i]))!="undefined"){
			$("#ver"+tipos[i]).css("border-color","#"+$("#ver"+tipos[i]).data("color"));
			$("#ver"+tipos[i]).mouseover(function(e) {
				$(this).css("cursor","pointer");
				$("."+$(this).data("tipo")).mouseover();						
				$("#nombrePuesto").html(cadActual.info);
			}).mouseout(function(e) {
				$(this).css("cursor","default");
				$("."+$(this).data("tipo")).mouseout();
				//$("#nombrePuesto").html(cadActual.info);
			}).click(function(e) {
				e.preventDefault(); 
			});
		}
	}
});

