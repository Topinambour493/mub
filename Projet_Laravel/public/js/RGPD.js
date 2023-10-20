const check_up = document.cookie
  .split('; ')
  .find(row => row.startsWith('check_up='))

if (check_up=='check_up=yes') {
   close_popup() 
  } else {
    document.querySelector(".fond_opaque").style.display="inline";
  }

function close_popup() {
    document.body.style.pointerEvents="auto";
    document.body.style.overflow="auto";
    document.querySelector(".fond_opaque").style.display="none";
    document.cookie = "check_up=yes";
}
