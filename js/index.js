document.getElementById("addPopup").style.display = "none";
document.getElementById("managePanel").style.display = "none";
document.getElementById("sharedFilesContainer").style.display = "none"; 
$(document).ready(function(){
    $("#file").on('change',function(){
        var label = document.getElementById("filesToUpload");
        var filesInput = document.getElementById("file");
        if(filesInput.files.length > 1){
            label.innerHTML = filesInput.files.length + " files selected";
        }else{
            label.innerHTML = filesInput.value.replace('C:\\fakepath\\','');
        }
    });
});
function ShowAddForm(){
    addForm = document.getElementById("addPopup");
    if (addForm.style.display == "none"){
        addForm.style.display = "block";
    }else{
        addForm.style.display = "none";
    }
}

function ShowManagePanel(fileTitle,owner){
    panel = document.getElementById("managePanel");
    panel.style.display = "block";
    title = document.getElementById("managePanelTitle");
    title.innerHTML = fileTitle;
    document.getElementById("fileHidden").value=fileTitle; 
    document.getElementById("fileNameHidden").value=fileTitle; 
    document.getElementById("ownerHidden").value=owner; 
    document.getElementById("fileOwnerHidden").value=owner; 
    //document.getElementById("openButton").onclick = function(){
    //    window.open('uploads/'+fileTitle,'_blank');
   //// }
    downloadB = document.getElementById("downloadButton");
    downloadB.href = "/uploads/" + owner + "/" + fileTitle;
}
function Submit(){
    const files = document.querySelector('[type=file]').files
    var formData = new FormData()
    
    formData.append('value',document.getElementById('isShared').checked);
    for( let i = 0; i < files.length; i++){
        let file = files[i]
        formData.append('files[]',file)
    }
    console.log(formData);
    fetch('php/upload.php',{
        method:'POST',
        body:formData,
    }).then((response)=>{
        location.reload()
        console.log(response);
    })

    //document.getElementById("uploadForm").submit();
}
function DeleteFile(){
    let fileName = document.getElementById("fileNameHidden").value.toString();
    let fileOwner = document.getElementById("fileOwnerHidden").value.toString();
    if(confirm("Delete " + fileName + "?")){
        let formData = new FormData();
        formData.append('filename',fileName);
        formData.append('owner',fileOwner);
        fetch('../php/delete.php',{
            method: 'POST',
            body: formData,
        }).then((response)=>{
            console.log(response);
            location.reload();
        }); 
    }
}
function ShareFile(){
    let fileName = document.getElementById("fileNameHidden").value.toString();
    let fileOwner = document.getElementById("fileOwnerHidden").value.toString();
    let formData = new FormData();
    formData.append('filename',fileName);
    formData.append('owner',fileOwner);
    fetch('../php/share.php',{
        method: 'POST',
        body: formData,
    }).then((response)=>{
        console.log(response);
        alert(fileName + " shared!");
        location.reload();
    }); 
}
function SwitchFolder(username){
    var userContainer = document.getElementById("userFilesContainer");
    var sharedContainer = document.getElementById("sharedFilesContainer"); 
    var button = document.getElementById("selectedFolder");
    if(userContainer.style.display != "none"){
        userContainer.style.display = "none";
        sharedContainer.style.display = "block";
        document.getElementById("title").innerHTML = "Shared folder";
        button.value = "My library";
    }else{
        userContainer.style.display = "block";
        sharedContainer.style.display = "none";
        document.getElementById("title").innerHTML = "My library ("+username+")";
        button.value = "Shared Folder";
    }
}
