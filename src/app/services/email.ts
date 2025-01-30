export interface Email {
   
    nombre:string;
    apellido:string;
    email:string;
    celular:string;
    mensaje:string;
    job:string;
    industry:string;
    company:string;
    acepto:string;
}

export interface EmailTerapeuta{
    nombre:string;
    apellido:string;
    email:string;
    celular:string;
    mensaje:string;
    tipo_de_terapia:string;
    modalidad:string;
    zona:string;
    online:boolean;
    presencial:boolean;
    domicilio:boolean;
    acepto:boolean;
    
}