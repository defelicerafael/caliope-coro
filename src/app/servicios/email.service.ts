import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { catchError,tap,throwError} from 'rxjs';
import {Email} from './email';


@Injectable({
  providedIn: 'root'
})

export class EmailService {
  
  public servidor:string= ''; 
  public loading:boolean = false;
  public dominio = window.location.hostname;
  public href: string = '';
  public protocol: string = '';
  

  private handleError(error: HttpErrorResponse) {
    if (error.status === 0) {
      console.error('An error occurred:', error.error);
    } else {
      console.error(
        `Backend returned code ${error.status}, body was: `, error.error);
    }
    return throwError(() => new Error('Something bad happened; please try again later.'));
  } 

  

  mandarEmail(email:Email){
    this.loading = true;
    const url = this.servidor+'send.php'; // URL to web api
    const options = new HttpParams()
      .set('nombre', email.nombre)
      .set('apellido', email.apellido)
      .set('celular', email.celular)
      .set('email', email.email)
      .set('mensaje', email.mensaje)
    ;
    return this.http.post(url,options)
      .pipe(
        catchError(this.handleError),
        tap(
          val=>{this.loading = false;}
        )
      )
  }

  mandarEmailUsuario(nombre:string,email:string,id:string){
    const url = this.servidor+'enviar-pass.php'; // URL to web api
    const options = new HttpParams()
      .set('nombre', nombre)
      .set('email', email)
      .set('id', id)
      
    ;
    return this.http.post(url,options)
      .pipe(
        catchError(this.handleError),
        tap(
          val=>{this.loading = false;}
        )
      )
  }

  mandarEmailAsociado(email:any){
    const url = this.servidor+'send-asociate.php'; // URL to web api
    const options = new HttpParams()
      .set("nombre",email.nombre)
      .set("apellido",email.apellido)
      .set("celular",email.celular)
      .set("email",email.email)
      .set("dni",email.dni)
      .set("reprocann",email.reprocann)
      .set("codigo_vinculacion",email.codigo_vinculacion)
      .set("fechareprocann",email.fechareprocann)
      .set("codigopostal",email.codigopostal)
      .set("calle",email.calle)
      .set("numero",email.numero)
      .set("departamento",email.departamento)
      .set("provincia",email.provincia)
      .set("localidad",email.localidad)
    ;
    return this.http.post(url,options)
      .pipe(
        catchError(this.handleError),
        tap(
          val=>{this.loading = false;}
        )
      )
  }

  constructor(
    private http: HttpClient,
  ) {
    this.href = window.location.hostname;
    this.protocol = window.location.protocol;
    //console.log(this.protocol+this.href);

    if(this.href==='localhost'){
      this.servidor = this.protocol+"//"+this.href+'/laronda/server/contact/';

    }else{
      this.servidor = this.protocol+"//"+this.href+'/server/contact/';
    }
    
  }
}
