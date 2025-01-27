import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ProvinciasService {

  constructor() {}
  
  public provincias = [
    {nombre:'Buenos Aires'},
    {nombre:'Ciudad Autónoma de Buenos Aires'},
    {nombre:'Catamarca'},
    {nombre:'Chaco'},
    {nombre:'Chubut'},
    {nombre:'Córdoba'},
    {nombre:'Corrientes'},
    {nombre:'Entre Ríos'},
    {nombre:'Formosa'},
    {nombre:'Jujuy'},
    {nombre:'La Pampa'},
    {nombre:'La Rioja'},
    {nombre:'Mendoza'},
    {nombre:'Misiones'},
    {nombre:'Neuquén'},
    {nombre:'Río Negro'},
    {nombre:'Salta'},
    {nombre:'San Juan'},
    {nombre:'San Luis'},
    {nombre:'Santa Cruz'},
    {nombre:'Santa Fe'},
    {nombre:'Santiago del Estero'},
    {nombre:'Tierra del Fuego, Antártida e Islas del Atlántico Sur'},
    {nombre:'Tucumán'}
  ] 
  
  private provinciasSubjetc = new BehaviorSubject(this.provincias);
  public provincias$: Observable<any> = this.provinciasSubjetc.asObservable();
  

  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  

}
