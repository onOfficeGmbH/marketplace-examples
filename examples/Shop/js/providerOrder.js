function processOrderToonOffice(obj, circleofUsers)
{
    var productsTotalPrice = $(obj).attr('data-value');
    var productsData = [];


    productsData.push({
	"name" : $(obj).parent().find('.product-name').text(),
	"price" : productsTotalPrice,
	"quantity" : 1,
	"circleofusers" : circleofUsers
    });

    var postData = {
	'parametercacheid': getUrlParameter('parameterCacheId'),
	'products': productsData,
	'productstotalprice': productsTotalPrice
    };

    signProcessData(postData);
}

function processAboOrderToonOffice(obj, circleofUsers)
{
    var aboItem = $(obj).parent();
    var aboData = null;

    aboData =
	{
	    "durationinmonth" : $(aboItem).find('#abo_durationInMonth').val(),
	    "noticeperiod" : $(aboItem).find('#abo_noticePeriod').val(),
	    "automaticrenewal" : $(aboItem).find('#abo_automaticRenewal').val(),
	    "monthlycosts" : $(aboItem).find('.product-price').attr('data-value'),
	    "monthlyservicedescription" : $(aboItem).find('.product-name').text(),
	    "circleofusers" : circleofUsers
	};

    var postData = {
	'parametercacheid': getUrlParameter('parameterCacheId'),
	'abo': aboData
    };

    signProcessData(postData);
}

function signProcessData(postData)
{
    var request = $.ajax({
	url: 'CreateProductJsonOrderwithSignature.php',
	method: 'POST',
	data: postData
    });

    request.done(function(data) {
	postDataToonOffice(data);
    });

    request.fail(function(jqXHR, textStatus ) {
	alert('Ihre Bestellung konnte nicht übermittelt werden. (' + textStatus+')');
    });
}

function postDataToonOffice(jsonContent)
{
    var target = window.parent;
    target.postMessage(jsonContent, '*');
}

//This function is only used to get the 'parameterCacheId' from the url
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