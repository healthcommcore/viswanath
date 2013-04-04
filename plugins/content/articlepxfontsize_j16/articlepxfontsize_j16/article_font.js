/*
Plugin Article PXFont Size for Joomla! v2.5
Copyright (C) 2012 (http://www.karmany.net)
License GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
	
Please retain this copyright notice.
You can use this code if this copyright notice are included
*/

//Los tags que seran modificados estan en el array tgs, que es pasado por php
var sz = new Array();
var sz_inicial = 10;
var sz_maximo = 10;
var sz_minimo = 10;
var formato = "px";
var sz_inc = 1;

function init_common_datos (inicial,maximo,minimo,txt_format,inc)
{
	//Inicializa todos los datos comunes
	sz_inicial = inicial;
	sz_maximo = maximo;
	sz_minimo = minimo;
	formato = txt_format;
	sz_inc = inc;	
}
function init_individual_datos (contador)
{
	//Inicializa solo los datos individuales
	sz[contador] = sz_inicial;
}

function modify_size(busca,inc,contador) {
	
	var doc = document,eldoc = null,busca_tgs,i,j;

	switch (inc)
	{
		case 0: //Reset
			sz[contador] = sz_inicial;
			break;
		case 1: //Incrementa
			inc = sz_inc;
			sz[contador] += inc;
			if ( sz[contador] > (sz_maximo)) sz[contador] = sz_maximo;
			break;
		case -1: //Decrementa
			inc = sz_inc*(-1);
			sz[contador] += inc;
			if ( sz[contador] < sz_minimo ) sz[contador] = sz_minimo;
			break;
		case 2: //Boton visual
			sz[contador] = sz_maximo;
			break;
	}
	
	busca = busca + contador;
	
	//Buscamos el div con Id
	if (!(eldoc = doc.getElementById(busca))) return;
	eldoc.style.fontSize = sz[contador] + formato;
	
	for (i=0; i<tgs.length; i++)
	{
		busca_tgs = eldoc.getElementsByTagName( tgs[i] );
		for (j=0; j<busca_tgs.length; j++) busca_tgs[j].style.fontSize = sz[contador] + formato;
	}	
}
