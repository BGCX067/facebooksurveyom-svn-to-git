function displayhide() {

	document.vignette_data.link_internal.style.display = 'none';
	document.vignette_data.link_external.style.display = 'none';
	
	if (document.vignette_data.link_type.selectedIndex == 0)	document.vignette_data.link_internal.style.display = '';
	if (document.vignette_data.link_type.selectedIndex == 1)	document.vignette_data.link_external.style.display = '';
	
	
	
}


