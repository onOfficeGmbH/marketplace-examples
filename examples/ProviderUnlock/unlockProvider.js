function unlockProvider(){

    var spinner = document.getElementById('spinner'),
        button = document.getElementById('unlockButton'),
        successMessage = document.getElementById('successMessage'),
        secretTextInput = document.getElementById('secret'),
        secretDiv = document.getElementById('secretDiv'),
        secret = secretTextInput.value;

    var arguments = getArguments();

    var token = arguments.getParameterToken,
        parameterCacheId = arguments.getParameterCacheId;

    spinner.style.visibility = 'visible';
    button.style.visibility = 'hidden';

    //setTimeout is simply to show spinner - remove if sent to provider
    setTimeout(function(){
        var data = new FormData();
        data.append('token', token);
        data.append('secret', secret);
        data.append('parameterCacheId', parameterCacheId);

        var httpRequest = new XMLHttpRequest();
		//An example of implementation can be found here https://github.com/onOfficeGmbH/sdk/blob/master/examples/03-marketplace-unlock-provider.php
        var url = '<PAGE CREATED BY PROVIDER MAKING API CALL "unlockProvider">';

        httpRequest.onreadystatechange  = function(){
            if (httpRequest.readyState === 4 && httpRequest.status === 200){
                spinner.style.visibility = 'hidden';
                var responseText = httpRequest.responseText.replace(/\'/gi, '');
                if (responseText === "active"){
                        secretTextInput.style.visibility =  'hidden';
                        secretDiv.style.visibility = 'hidden';
                        successMessage.style.visibility = 'visible';
                }
                else{
                        button.style.visibility = 'visible';
                }
                updateParent(responseText);
            }
        };

        httpRequest.open('POST', url, true);
        httpRequest.send(data);
    }, 1000);
}

function getArguments()
{
    arguments = {
	"getParameterToken":getUrlParameter('apiToken'),
	"getParameterCacheId":getUrlParameter('parameterCacheId'),
	};

    return arguments;
}

function updateParent(message){
    var target = window.parent;
    target.postMessage(message, '*');
}

//This function is only used to get the parameter from the url
function getUrlParameter(sParam)
{
    var url = window.location.search.substring(1), urlvariables = url.split('&'), parameterName, i;

    for (i = 0; i < urlvariables.length; i++)
    {
        parameterName = urlvariables[i].split('=');

        if (parameterName[0] === sParam) {
            return parameterName[1] === undefined ? true : decodeURIComponent(parameterName[1]);
        }
    }
}