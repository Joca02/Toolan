function validateForm() {
    var password1 = document.getElementsByName('password')[0].value;
    var password2 = document.getElementsByName('password2')[0].value;

    if (password1 !== password2) {
        alert('Passwords do not match!');
        return false; //ne prolazi
    }
    var username=document.getElementsByName('username')[0].value;
    var name=document.getElementsByName('name')[0].value;
    console.log(username+" "+username.length);
  if(password1.length<5)
  {
    alert("Password must have at least 5 characters.");
    return false;   
  }
  if(name.length<2)
  {
    alert("Name must have at least 2 characters.");
    return false;
  }

  if(username.length<5)
  {
    alert("Username must have at least 5 characters.");
    return false;
  }
    
    //prolazi form submission
    return true; 
}