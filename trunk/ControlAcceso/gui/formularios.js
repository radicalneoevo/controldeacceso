
// Coloca el foco sobre el primer elemento del primer formulario, si existe
window.onload = function()
{
    if(document.forms.length >= 1)
        for(var i = 0; i <= document.forms[0].elements.length - 1; i++)
        {
            var campo = document.forms[0].elements[i];
            if(campo.type == "text" || campo.type == "submit")
            {
                campo.focus();
                return;
            }
        }
}