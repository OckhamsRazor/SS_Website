var queryString = window.top.location.search.substring(1);
function getParameter ( parameterName ) {
	var parameterName = parameterName + "=";
	if ( queryString.length > 0 ) {
		begin = queryString.indexOf ( parameterName );
		if ( begin != -1 ) {
			begin += parameterName.length;
			end = queryString.indexOf ( "&" , begin );
			if ( end == -1 ) {
				end = queryString.length
			}
			return unescape ( queryString.substring ( begin, end ) );
		}
		return "null";
	}
}

