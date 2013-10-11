function redirection( seconde, url )
{
	micro = seconde * 1000;
	self.setTimeout("self.location.href = '" + url + "';", micro);
}