
var formDatafiles = new FormData();
var messages_array = new Object();
var cantidad_files = 0;
function cargar_mas(id_conversacion){
    $.ajax({
        url:"more_messages.php",
        type:"POST",
        dataType:"json",
        data:{'id_conversacion':id_conversacion,'messages':messages_array["conversation_"+id_conversacion]}
    }).done(function(success){
        //remuevo primero la capa de cargar mas
        $(".chat-list").find(".link-cargar").remove();
        var resultado = success["resultado"];
        var mensajes = success["mensajes"];
                var cantidad = mensajes.length;
                var id_conversacion = success["id_conversacion"];
                var array_m = new Array();
                if(messages_array["conversation_"+id_conversacion] == undefined){
                    //todavia no se crea
                    messages_array["conversation_"+id_conversacion] = new Array();
                }
                else{

                }
                
                for(var i = 0;i<cantidad;i++){
                    var msg = mensajes[i];
                    var id_mensaje = msg[0];
                    var mensaje = msg[1];
                    var apodo_m = msg[2];
                    var date = msg[3];
                    var access = msg[4];
                    var classe = msg[5];
                    if(classe == "inverse"){
                        //es un mensaje propio
                        $(".chat-list").prepend('<li class="reverse"> '+
                                                '<div class="chat-content">'+
                                                    '<h5>'+apodo_m+'</h5>'+
                                                    '<div class="box-out"><div class="box-chat-user bg-primary" title="'+date+'" id="mensaje_'+id_mensaje+'" data-placement="top">'+mensaje+'</div></div>'+
                                                '</div>'+
                                                '<div class="chat-img"><img src="../assets/images/users/5.jpg" alt="user" /></div>'+
                                            '</li>');
                    }
                    else{
                        $(".chat-list").prepend('<li class=""> '+
                        '<div class="chat-img"><img src="../assets/images/users/5.jpg" alt="user" /></div>'+
                                                '<div class="chat-content">'+
                                                    '<h5>'+apodo_m+'</h5>'+
                                                    '<div class="box-out"><div class="box-chat-user bg-primary" title="'+date+'" id="mensaje_'+id_mensaje+'" data-placement="top">'+mensaje+'</div></div>'+
                                                '</div>'+
                                            '</li>');
                    }
                    $("#mensaje_"+id_mensaje).tooltip();
                    messages_array["conversation_"+id_conversacion].push(id_mensaje);
                }
                $(".chat-list").prepend("<p class='text-center link-cargar'><a href=\"javascript:cargar_mas("+id_conversacion+");\">Cargar más</a></p>");
    }).fail(function(error){
        alert(error);
    })
}
$(".btn-adjunto").on("click",function(e){
    $("#attachment").click();
});
$("#attachment").change(function() {
    var files = $("#attachment")[0].files;
    var cantidad = files.length;
    for(var i = 0;i<cantidad;i++){
        cantidad_files++;
        var file = files[i];
        formDatafiles.append("file_"+cantidad_files,file);
        var fileName = file.name;
        var fileSize = file.size;
        var fileType = file.type;
        var extension = fileName.replace(/^.*\./, '').toUpperCase();
        var caracteres = fileName.length;
        if(caracteres > 10){
            fileName = fileName.substring(0,10);
            fileName+="...";
        }
        else{

        }
        

        //capa de agregar
        var capa = '<div class="col-md-2 data-files" data-attachment="'+cantidad_files+'"> '+
                    '<div class="attachment-preview">'+
                    '   <div class="attachment-icon">'+
                    '       <i class="fa fa-file icon"></i>'+
                    '   </div>'+
                    '   <div class="attachment-content2">'+
                    '       <span class="attachment-name">'+extension+'</span>'+
                    '       <span class="attachment-description">'+fileName+'</span>'+
                    '   </div>'+
                    '   <span onclick="remove_Attachment('+cantidad_files+');" title="Remover archivo adjunto" class="removeAttachment"><i class="fa fa-times"></i></span>'+
                    ' </div>'+
                    ' </div>';
                    $(".row-attachments").append(capa);
    }
});

function remove_Attachment(attachment){
    $("[data-attachment="+attachment+"]").remove();
    formDatafiles.delete("file_"+attachment);
}