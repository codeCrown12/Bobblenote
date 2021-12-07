  //function for nav-tabs
  function viewSetting(evt, setting) {
    // Declare all variables
    var tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (let i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active-tab"
    tablinks = document.getElementsByClassName("tablinks");
    for (let i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active-tab", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(setting).style.display = "block";
    evt.currentTarget.className += " active-tab";
  }