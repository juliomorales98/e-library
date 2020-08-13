const url = 'process.php'
const form = document.querySelector('form')

form.addEventListener('submit', (e)=>{
    e.preventDefault()
    
    const file = document.querySelector('[type=file]').files
    const formData = new FormData()

   formData.append('files[]',file[0])

    fetch(url,{
        method:'POST',
        body:formData,
    }).then((response)=>{
        location.reload()
    })
})
