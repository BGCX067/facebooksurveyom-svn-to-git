function displayhide() {

	document.link_type.link_internal.style.display = 'none';
	document.link_type.link_external.style.display = 'none';
	
	if (document.link_type.link_type.selectedIndex == 0)	document.link_type.link_internal.style.display = '';
	if (document.link_type.link_type.selectedIndex == 1)	document.link_type.link_external.style.display = '';
	
	
	
}


