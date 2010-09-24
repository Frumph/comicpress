var BookmarkInfo = Class.create({
  'def': {
	  'permalink': false
	},
	'initialize': function() {
	  this.jar = new CookieJar({
	    'expires': 60 * 60 * 24 * 31,
	    'path': '/'
	  });
	},
	'read': function() {
	  var bookmark_info = this.jar.get('bookmark-info');

	  if ((typeof(bookmark_info) != 'object') || (bookmark_info == null)) {
	    bookmark_info = this.def;
	  }

	  return bookmark_info;
	},
	'write': function(bookmark_info) {
	  this.jar.put('bookmark-info', bookmark_info);
	  if (this.onWrite) { this.onWrite(bookmark_info); }
	}
});

var ComicBookmark = {};
ComicBookmark.setup = function(id, mode, url, elements) {
	var bookmark_info = new BookmarkInfo();
	var info = bookmark_info.read();

	if ($(id)) {
		var hrefs = {};
	  $$('#' + id + ' a').each(function(a) {
	    var name = $w(a.className).shift();
	    hrefs[name] = a;
	  });

		switch (mode) {
			case 'three-button':
			  var set_goto_tag = function(i) {
			    hrefs['goto-tag'].href = (i.permalink ? i.permalink : "#");
			    ['goto-tag','clear-tag'].each(function(which) {
			      hrefs[which].innerHTML = elements[which + '-' + (i.permalink ? "on" : "off")];
			    });

			    $H(hrefs).each(function(info) {
			    	info.value[i.permalink ? 'addClassName' : 'removeClassName']('active');
			    });
			  };

			  hrefs['tag-page'].innerHTML = elements['tag-page'];

			  bookmark_info.onWrite = function(i) { set_goto_tag(i); }
			  set_goto_tag(info);

				hrefs['tag-page'].observe('click', function(e) {
					Event.stop(e);
					info.permalink = url;
					bookmark_info.write(info);
				});

				hrefs['goto-tag'].observe('click', function(e) {
					if (hrefs['goto-tag'].href == "#") { Event.stop(e); }
				});

			  hrefs['clear-tag'].observe('click', function(e) {
			    Event.stop(e);
			    info.permalink = false;
			    bookmark_info.write(info);
			  });

				break;
			case 'one-button':
			  var set_goto_tag = function(i) {
			    hrefs['bookmark-clicker'].href = (i.permalink ? i.permalink : "#");
		      hrefs['bookmark-clicker'].innerHTML = elements['bookmark-clicker-' + (i.permalink ? "on" : "off")];
		      hrefs['bookmark-clicker'][i.permalink ? 'addClassName' : 'removeClassName']('active');
			  };
			  bookmark_info.onWrite = function(i) { set_goto_tag(i); }
			  set_goto_tag(info);

			  hrefs['bookmark-clicker'].observe('click', function(e) {
			  	var current_link = info.permalink;
			    info.permalink = (hrefs['bookmark-clicker'].href.match(/#$/)) ? url : false;
			    bookmark_info.write(info);

			    if (hrefs['bookmark-clicker'].href.match(/#$/) == null) {
						hrefs['bookmark-clicker'].href = url;
						Event.stop(e);
					} else {
						document.location.href = current_link;
						Event.stop(e);
					}
			  });

				break;
		}
	}
};
