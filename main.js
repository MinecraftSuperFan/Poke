var username = null;
var roomnumber = null;
var enterroom = false;
var master = false;
var start = 0;
var banroom = [0,0];
var time = 0;
var stage = 1;
var money = 0;
if (document.cookie.indexOf('username') >= 0) {
  username = document.cookie.replace(/(?:(?:^|.*;\s*)username\s*\=\s*([^;]*).*$)|^.*$/, "$1");
} else {
  var accept = confirm('We use cookies to improve your experience on our site. Do you accept?');
  if (accept) {
    username = Math.random() * 100;
    document.cookie = "username=" + username;
  }
}
document.getElementById("user").innerHTML = "user: " + username;
////////////
$.post('getmoney.php', {user: username}, function(response) {
document.getElementById("money").innerHTML = "Tổng tiền: " + response;
money = response
});
////////////
function join(rnb)
{
  roomnumber = rnb;
  $.get('join.php', {user: username,room: roomnumber}, function(response) 
  {
  });
  document.getElementById("roomnumber").innerHTML = rnb;
}
////////////
function leave()
{
  $.get('leave.php', {user: username,room: roomnumber}, function(response) 
  {
    master = false;
    enterroom = false;
    roomnumber = null;
    $("#home").css(
      {"display": "initial"});
    $("#game").css(
      {"display": "none"});
    $("#playermove").css({"display":"none"});
    $("#start").css({"display":"none"});
  });
}
////////////
function st()
{
  start = 1;
}
////////////
function kick(p,s)
{
  alert("hàng trưng bày không dùng được");
  if(username = 999999999)
  {
  if(s == 0 && start != 1)
  {
    const button = document.getElementById("kick");
    const dropdown = document.createElement("select");
    dropdown.style.width = button.offsetWidth + "px";
    dropdown.style.marginTop = "10px";
    const options = [];
    $('#playerplace').find('div').each(function() {
    options.push($(this).html());
    });
    for (let i = 0; i < options.length; i++) {
    const option = document.createElement("option");
    option.value = options[i];
    option.text = options[i];
    option.addEventListener("click", function() 
    {
      kick(option[i],1);
    });
    dropdown.appendChild(option);
  }
  button.parentNode.insertBefore(dropdown, button.nextSibling);
  }
  if(s == 1)
  {
    $("body select").empty();
    $.get("kick.php", {name: username, room: roomnumber, player:p}, function(res) {
    });
  }
}
}
////////////
function action(a)
{
  $.get("action.php", { room: roomnumber, user: username,action: a}, function(res) {
    if(res == "0")
    {
      alert("chưa đến lượt");
    }
    else if(res == "bạn phải đặt cược")
    {
      alert(res);
    }
    else
    {
      $("#paction").html(res);
    }
  });
}
////////////
function loadroom()
{
$.get('room.php', {}, function(respons) {
  $("#room").children().not("#create").remove();
      response = respons.split(".");
        for (var i = 0; i < (response.length - 1); i++) {
    if(!banroom.includes(response[i]) && !response[i].includes("card") && !response[i].includes("stage"))
    {
    var div = document.createElement("div");
    div.id = response[i];
    div.innerHTML = "phòng: " + response[i] + "||nhấn để tham gia";
    div.onclick = function() 
    {
      join(div.id);
    };
    $(div).css(
      {"width": "44vh", 
       "height": "10vh",
       "float": "left",
       "position": "static",
       "background-color": "lightgray",
       "border": "0.2vh solid black",
       "margin-left": "3vh",
      }
      );
document.getElementById("room").appendChild(div);
        }
        }
    }
);
}
///////////
function create() 
{
  $.post("createroom.php", {user: username}, function(response) {
      roomnumber = response;
      document.getElementById("roomnumber").innerHTML = roomnumber;
});
  master = true;
}
///////////
function gameupdate()
{
  $.post("gameupdate.php", { room: roomnumber, start: start,user: username }, function(res) {
    if(start == 0)
    {
    
      $("#playerplace").children().remove();
      var response = res.split("-");
      for(i = 0; i< (response.length - 1);i++)
        {
          if(!username.includes(response[i]))
          {
          var div = document.createElement("div");
          div.id = response[i];
          div.innerHTML = response[i];
          $(div).css(
          {"width": "25vw", 
           "height": "20vw",
           "float": "left",
           "position": "relative",
           "background-color": "lightgray",
           "border": "0.2vw solid gray",
           "margin": "2vw",
           "overflow-x":"hidden"
          });
          var p = document.createElement("p");
          p.id = response[i] + "bet";
          $(p).css(
          {"width": "20vw", 
           "height": "5vw",
           "float": "left",
           "position": "absolute",
           "color":"green",
           "bottom": "0px",
           "overflow-x":"hidden",
           "font-size":"4vw"
          });
          var pt = document.createElement("p");
          pt.id = response[i] + "time";
          $(p).css(
          {"width": "4vw", 
           "height": "4vw",
           "float": "right",
           "position": "absolute",
           "color":"blue",
           "bottom": "0px",
           "overflow-x":"hidden",
           "font-size":"5vw"
          });
          div.appendChild(p);
          div.appendChild(pt);
        document.getElementById("playerplace").appendChild(div);
          }
      }
    }
    if(start == 1)
    {
      if(res.includes("hand"))
      {
        alert(res);
      }
      else if(res.includes("stage3"))
      {
        var card = res.split(":");
        $("#pcard1").css(
        {"background-image": "url(png_96_dpi/"+card[0]+".png)",
         "background-size": "cover"
        });
        $("#pcard2").css(
        {"background-image": "url(png_96_dpi/"+card[1]+".png)",
         "background-size": "cover"
        });
        $("#pcard3").css(
        {"background-image": "url(png_96_dpi/"+card[2]+".png)",
         "background-size": "cover"
        });
        $("#pcard4").css(
        {"background-image": "url(png_96_dpi/"+card[3]+".png)",
         "background-size": "cover"
        });
        $("#pcard5").css(
        {"background-image": "url(png_96_dpi/"+card[4]+".png)",
         "background-size": "cover"
        });
      
      }
      else
      {
      var parray = res.split("-");
      var card = parray[0].split(":");
      $("#card2").css(
      {"background-image": "url(png_96_dpi/"+card[2]+".png)",
         "background-size": "cover"
      }
      );
      $("#card1").css(
      {"background-image": "url(png_96_dpi/"+card[1]+".png)",
         "background-size": "cover"
      }
      );
      for(i = 0; i< (parray.length - 1);i++)
      { 
        card = parray[i].split(":");
        if(card[3] != null)
        {
          if(!username.includes(card[0]))
          {
          $("#"+card[0]+"time").html(card[3]);
          }
          else
          {
          $("#ptime").html(card[3]);
          }
        }
        if(card[4] != null)
        {
          if(!username.includes(card[0]))
          {
          $("#"+card[0]+"bet").html(card[5]);
          }
          else
          {
          $("#paction").html(card[4]);
          }
        }
        }
      }
    }
});
}
//////////
setInterval(()=>
{
  if(enterroom == false)
  {
    if(roomnumber != null)
    {
      $("#home").css(
      {"display": "none"});
      $("#game").css(
      {"display": "initial"});
      enterroom = true;
    }
    loadroom();
  }
  else if(enterroom == true)
  {
    if(master == true)
    {
      $("#start").css({"display":"initial"});
    }
    if(start == 1)
    {
      $("#playermove").css({"display":"initial"});
    }
    $.get('start.php', {room: roomnumber}, function(response) 
    {
      if(response == "1" && response == 1)
      {
        start = 1;
      }
    });
    document.getElementById("pmoney").innerHTML = money;
    gameupdate();
  }
},1000);