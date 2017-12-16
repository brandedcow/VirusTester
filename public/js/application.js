$(function() {
  // Take in form
  // runs through form validation functions
  function validate(form) {
    fail = validateUsername(form.username.value)
    fail += validateEmail(form.email.value)
    fail += validatePassword(form.password.value)

    if (fail == "") return true
    else { alert(fail); return false }
  }

  // Take in form field
  // Checks for contents, length, and characters
  function validateUsername (field) {
    if (field == "")
      return "Username cannot be blank.\n"
    else if (field.length < 5)
      return "Username must be at least 5 characters long.\n"
    else if (/[^a-zA-Z0-9_-]/.test(field))
      return "Only a-z, A-Z, 0-9, - and _ allowed in Username.\n"
    return ""
  }

  // Take in form field
  // Checks for contents, valid email
  function validateEmail (field) {
    if (field == "")
      return "Email cannot be blank.\n"
    else if ( (field.indexOf(".") < 2 ) && (field.indexOf("@") <1) || /[^a-zA-Z0-9.@_-]/.test(field) )
      return "Invalid Email Address.\n"
    return ""
  }

  // Take in form field
  // Checks for contents, length
  function validatePassword (field) {
    if (field == "") return "Password cannot be blank.\n"
    else if (field.length < 8)
      return "Password must be at least 8 characters long.\n"
    return ""
  }

});
