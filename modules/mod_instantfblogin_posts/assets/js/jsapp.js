jQuery(function(g){var f="https://www.googleapis.com/plus/v1/people/",h="/activities/public",b="items(published,title,url,object(content,attachments),actor(displayName,url,image(url)))",d=ifblGooglePostsUser,e=ifblGooglePostsApiKey,c=ifblGooglePostsMaxResults;g.ajax({url:f+d+h+"?key="+e+"&fields="+b+"&maxResults="+c,crossDomain:true,dataType:"jsonp"}).done(function(o){if(typeof(o.items)!=="undefined"){var n=this,j=o.items,l=0,k="";for(l=0;l<j.length;l+=1){k+='<div class="itm">';k+='<div class="athr"><a href="'+j[l].actor.url+'" target="_blank" data-track="gplus|click|'+j[l].actor.displayName+'"><img src="'+j[l].actor.image.url+'" alt="" /><div class="name">'+j[l].actor.displayName+'<p class="username">'+d+'</p></div></a><div class="time">'+a(new Date(j[l].published).getTime())+"</div></div>";k+='<div class="cntnt"><p>'+j[l].object.content+"</p></div>";if(typeof(j[l].object.attachments)!=="undefined"){for(at=0;at<j[l].object.attachments.length;at+=1){if(typeof(j[l].object.attachments[at].image)!=="undefined"){var m='<img src="'+j[l].object.attachments[at].image.url+'"/>';k+=m}}}k+="</div>"}}g(".ifblgplus").html(k)});function a(j){var l=Math.floor((new Date()-j)/1000),k=Math.floor(l/31536000);if(k>1){return k+"y"}k=Math.floor(l/2592000);if(k>1){return k+"m"}k=Math.floor(l/86400);if(k>1){return k+"d"}k=Math.floor(l/3600);if(k>1){return k+"h"}k=Math.floor(l/60);if(k>1){return k+"m"}return Math.floor(l)+"s"}});