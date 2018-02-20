from django.http import HttpResponse

from django.shortcuts import render


from zeep import client




def home(request):

	wsdl  = 'http://ntx.pcscloud.net/XCASERVER_WEB/awws/XCAServer.awws?wsdl'
	client = zeep.Client(wsdl=wsdl)

	return HttpResponse("""

	    <h1>Phase 1 Identification</h1>

	    <h1>Email</h1>
	    <input type="mail" />

	""")