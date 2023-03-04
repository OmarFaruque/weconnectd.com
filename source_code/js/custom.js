document.addEventListener('DOMContentLoaded', function(){
async function copyTargetText(e) {
  try {
    await navigator.clipboard.writeText(e.innerText);
  } catch (err) {
    console.error("Failed to copy: ", err);
  }
}

document.querySelector("#copy").addEventListener("click", () => {
  const e = document.getElementById('url');
  copyTargetText(e);
  /*document.getElementById('copy-alert').style.display = 'block';
  setTimeout(() => {
    document.getElementById('copy-alert').style.display = 'none';
  }, 1500);*/
});
document.querySelector("#coinadd-copy").addEventListener("click", () => {
  const e = document.getElementById('coinadd');
  copyTargetText(e);
  /*document.getElementById('copy-alert').style.display = 'block';
  setTimeout(() => {
    document.getElementById('copy-alert').style.display = 'none';
  }, 1500);*/
});	
	
})
