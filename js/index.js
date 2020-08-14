document.getElementById("addPopup").style.display = "none";
document.getElementById("managePanel").style.display = "none";
function ShowAddForm(){
    addForm = document.getElementById("addPopup");
    if (addForm.style.display == "none"){
        addForm.style.display = "block";
    }else{
        addForm.style.display = "none";
    }
}

function ShowManagePanel(fileTitle){
    panel = document.getElementById("managePanel");
    panel.style.display = "block";
    title = document.getElementById("managePanelTitle");
    title.innerHTML = fileTitle;
    document.getElementById("fileHidden").value=fileTitle; 
    document.getElementById("openButton").onclick = function(){
        window.open('uploads/'+fileTitle,'_blank');
    }
}
