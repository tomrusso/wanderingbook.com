var map = null;
var clickEvent = null;
var timer = null;
var singleClickEnabled = false;
var pushpin = null;

// Initialize the map.
function GetMap(enableSingleClick)
{
	singleClickEnabled = enableSingleClick;
	if(document.getElementById('myMap'))
	{
		map = new VEMap('myMap');
	}
	else
	{
		return;
	}
	map.LoadMap();
	map.AttachEvent('onmousedown', onMouseDown);
	map.AttachEvent('onclick', onClick);
	map.AttachEvent('ondoubleclick', onDoubleClick);
}

function onMouseDown(e)
{
	clickEvent = e;
}

function onClick(e)
{
	// This if filters out drags.
	if(Math.abs(clickEvent.mapX - e.mapX) < 10 && Math.abs(clickEvent.mapY - e.mapY) < 10)
	{
		clearTimeout(timer);
		timer = setTimeout("handleTimeout()", 500);
		clickEvent = e;
	}
}

function onDoubleClick(e)
{
	clearTimeout(timer);
}

function handleTimeout()
{
	singleClick(clickEvent);
	clickEvent = null;
}

// This function places a pushpin on the map in response to a single
// click, when single click is enabled.
function singleClick(e)
{
	if(singleClickEnabled)
	{
		map.DeleteAllShapes();
		pushpin = new VEShape(VEShapeType.Pushpin, map.PixelToLatLong(new VEPixel(e.mapX, e.mapY)));
		pushpin.SetTitle("Title");
		pushpin.SetDescription("This is a description");
		map.AddShape(pushpin);
	}
}

function placeAllPushpins()
{
	mapRect = map.GetMapView();

	var query_string = 	"maxlat=" + mapRect.TopLeftLatLong.Latitude + "&" +
						"minlat=" + mapRect.BottomRightLatLong.Latitude + "&" +
						"maxlong=" + mapRect.BottomRightLatLong.Longitude + "&" +
						"minlong=" + mapRect.TopLeftLatLong.Longitude;

	var request = new XMLHttpRequest();
	request.open("GET", "all_books_xml.php?" + query_string, false);
	request.send(null);

	if(request.status == 200)
	{
		console.log(request.responseText);
		locList = eval(request.responseText);

		// *** TODO ***: comment obsolete, there are now 6 elements.
		// The list should always be a multiple of 4, since each pushpin
		// is defined by four things: latitude, longitude, title and body.
		if(locList.length % 6 != 0)
		{
			// ***TODO***: Should probably add some other error handling
			// or logging here.
			return;
		}

		var lastPoint = null;
		var curPoint = null;
		var line = null;
		for(var i = 0; i < locList.length; i += 6)
		{
			lastPoint = curPoint;
			curPoint = new VELatLong(locList[i + 1], locList[i + 2]),
			pushpin = new VEShape(VEShapeType.Pushpin, new Array(curPoint));
			pushpin.SetDescription(locList[i] + " by " + locList[i+4] + " on " + locList[i + 3] + "<br><hr>" + locList[i + 5]);
			pushpin = map.AddShape(pushpin);
		}
	}
	return;
}

// *** TODO ***: Need to upgrade this to use VE 6 shapes.
function placeBookPushpins(book_id)
{
	// *** TODO ***
	// pushpin is a global variable used to store the pushpin shape
	// when a map is single clicked (when in "indicate location" mode).
	// Should consider using a different variable here, or storing the
	// location pushpin differently.
	var request = new XMLHttpRequest();
	request.open("GET", "book_xml.php?id=" + book_id, false);
	request.send(null);

	if(request.status == 200)
	{
		locList = eval(request.responseText);

		// *** TODO ***: comment obsolete, there are now 6 elements.
		// The list should always be a multiple of 4, since each pushpin
		// is defined by four things: latitude, longitude, title and body.
		if(locList.length % 6 != 0)
		{
			// ***TODO***: Should probably add some other error handling
			// or logging here.
			return;
		}

		var lastPoint = null;
		var curPoint = null;
		var line = null;
		for(var i = 0; i < locList.length; i += 6)
		{
			lastPoint = curPoint;
			curPoint = new VELatLong(locList[i + 1], locList[i + 2]),
			//pushpin = new VEPushpin(	i,
			//							curPoint,
			//							null,
			//							"title",
			//							"body");
			pushpin = new VEShape(VEShapeType.Pushpin, new Array(curPoint));
			pushpin.SetDescription(locList[i] + " by " + locList[i+4] + " on " + locList[i + 3] + "<br><hr>" + locList[i + 5]);
			pushpin = map.AddShape(pushpin);
			//map.AddPushpin(pushpin);

			if(curPoint && lastPoint)
			{
				line = new VEShape(VEShapeType.Polyline, new Array(lastPoint, curPoint));
				line.HideIcon();
				map.AddShape(line);
			}
		}
	}
	return;
}

// *** TODO ***:
// This should be refactored.  The warning should be up in the page.  This function
// should just indicate whether a pushpin has been placed.  It could return the 
// pushpin's point, or null if it's not defined.  This function shouldn't be
// setting values in the doc directly.
function submitLocation(latElement, longElement)
{
	if(!pushpin)
	{
		alert("Click to place a pushpin on the map where\nyou found your book, then click submit.");
		return false;
	}
	else
	{
		pushpinPoint = pushpin.GetPoints()[0];
		latElement.value = pushpinPoint.Latitude;
		longElement.value = pushpinPoint.Longitude;
		return true;
	}
}
