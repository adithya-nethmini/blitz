function logoutcheck(){
    var result = window.confirm('Are you sure to logout?');
    if(result == false){
        event.preventDefault();
    }
}