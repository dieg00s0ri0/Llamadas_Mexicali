function habilitar() {
    input1=document.getElementById("Rmonitoreo").value;
    input2=document.getElementById("monitoreoI").value;
    select=document.getElementById("listames").value;
    val=0;
    if (select=="") {
        val++;
    }
    if (input1=="") {
        val++;
    }
    if (input2=="") {
        val++;
    }
    if(val==0){
        document.getElementById("btn").disabled=false;
    }else{
        document.getElementById("btn").disabled=true;
    }
}

document.getElementById("Rmonitoreo").addEventListener("change",habilitar);
document.getElementById("monitoreoI").addEventListener("change",habilitar);
document.getElementById("listames").addEventListener("change",habilitar);

