let boton = document.querySelector("#sendMail");

boton.addEventListener("click", function(evento){
	alert("Le has dado click");
    let data = {
        nombre: $("#fname").val(),
        telefono: $("#telefono").val(),
        emailCC: $("#email").val(),
        asunto: $("#subject").val(),
        mensaje: $("#message").val()
    }
    console.log(data);
    $.ajax({
        type: "POST",
        url: './php/sendMail.php',
        data,
        success: function(response)
        {
            console.log(response); 
        }
   });
});