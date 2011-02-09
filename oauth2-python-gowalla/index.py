import cgi
import urllib
import urllib2
import json

#client OAuth keys
key = 'KEY HERE'
secret = 'KEY HERE'

#gowalla URIs and callbacks
callback_url = "http://localhost:8080/"                          #INSERT CALLBACK URL HERE
authorization_endpoint = "https://gowalla.com/api/oauth/new"
access_token_endpoint = "https://api.gowalla.com/api/oauth/token"

#get query string parameters
params = cgi.FieldStorage()

"""
" If a code parameter is available in the query string then the user
" has given the client permission to access their protected data.
" If not, the script should forward the user to log in and accept
" the application permissions.
"""
if params.has_key('code'):
    code = params['code'].value
    
    #construct POST object for access token fetch request
    postvals = {'grant_type': 'authorization_code', 'client_id': key, 'client_secret': secret, 'code': code, 'redirect_uri': callback_url}
    
    #make request to capture access token
    params = urllib.urlencode(postvals)
    f = urllib.urlopen(access_token_endpoint, params)
    token = json.read(f.read())
    
    print "<h1>token</h1>"
    print token
    print "<br /><br />"
    
    #build headers for protected data request
    headers = { 'Accept': 'application/json' }
    
    #make OAuth signed request for protected user profile
    profile_url = "https://api.gowalla.com/users/me?oauth_token=" + token['access_token']
    request = urllib2.Request(profile_url, None, headers)
    response = urllib2.urlopen(request)
    profile = response.read()
    
    #print profile data response
    print 'Content-Type: text/plain'
    print ''
    print profile
    
    #construct POST object for access token refresh request
    postvals = {'grant_type': 'refresh_token', 'client_id': key, 'client_secret': secret, 'refresh_token': token['refresh_token']}
    
    #make request to refresh access token
    params = urllib.urlencode(postvals)
    refresh_req = urllib.urlopen(access_token_endpoint, params)
    new_token = json.read(refresh_req.read())
    
    print new_token
else:
    #construct Gowalla authorization URI
    auth_url = authorization_endpoint + "?redirect_uri=" + callback_url + "&client_id=" + key
    
    #redirect the user to the Gowalla authorization URI
    print "Location: " + auth_url
