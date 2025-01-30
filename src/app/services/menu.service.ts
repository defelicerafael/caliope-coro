import { Injectable } from '@angular/core';
export interface Section {
  name: string;
}
@Injectable({
  providedIn: 'root'
})
export class MenuService {

  public menu:{title: string, url: string,type:string,id:string,offset:number}[] = [];
  constructor() {
    this.menu = [
      {
        title:"Quienes Somos",url:"/",type:"url",id:'home',offset:15
      },
      {
        title:"Quienes Somos",url:"/",type:"url",id:'QuienesSomos',offset:15
      },
      {
        title:"Buscar profesionales",url:"/profesionales",type:"url",id:'profesionales',offset:155
      },
      {
        title:"Registrate",url:"/registrate",type:"url",id:'registrate',offset:40
      },
      {
        title:"Ingresar",url:"/resources",type:"boton",id:'terapeutas',offset:17
      }
    ]
    
  }

  public folders: {seccion:string,menues:{titulo:string,url:string,cdkEditor:boolean}[],}[] = [
    { 
      seccion:'Caliope',
      menues:[
        {titulo:"Profes",url:'profes', cdkEditor:false},
        {titulo:"Sedes",url:'sedes', cdkEditor:false},
        {titulo:"Calioperos",url:'calioperos', cdkEditor:false},
      ]
    },
    {seccion:'Administración',
      menues:[
        {titulo:"Secretarios",url:'secres', cdkEditor:false},
        {titulo:"Pagos",url:'pagos', cdkEditor:false},
        {titulo:"Asistencia",url:'asistencia', cdkEditor:false},
      ]
    },
    {seccion:'Audiciones',
      menues:[
        {titulo:"Audiciones", url:"audiciones", cdkEditor:false}
      ]
    },
    { 
      seccion:'Configuración',
      menues:[
        {titulo:"Bases de datos",url:'configuracion_bases', cdkEditor:false},
        {titulo:"Medios de pago",url:'medios_de_pago', cdkEditor:false},
        {titulo:"Usuarios",url:'users', cdkEditor:false},
        {titulo:"Criterios",url:'criterios', cdkEditor:false},
      ]
    }
  ]
}
