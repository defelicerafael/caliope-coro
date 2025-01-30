import { Injectable, afterNextRender  } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { catchError,tap,throwError} from 'rxjs';
import {Email, EmailTerapeuta} from './email';


@Injectable({
  providedIn: 'root'
})

export class EmailService {
  
  public servidor:string= 'http://psicologosenred.ar/server/contact/'; 
  public loading:boolean = false;
  public dominio:string = "";
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
    console.log(url);

    const options = new HttpParams()
      .set('nombre', email.nombre)
      .set('apellido', email.apellido)
      .set('celular', email.celular)
      .set('email', email.email)
      .set('mensaje', email.mensaje)
      .set('job', email.job)
      .set('industry', email.industry)
      .set('company', email.company)
      .set('acepto', email.acepto)
    ;
    return this.http.post(url,options)
      .pipe(
        catchError(this.handleError),
        tap(
          val=>{
            console.log(val);
            this.loading = false;
          }
        )
      )
  }

  mandarEmailATerapeuta(email:EmailTerapeuta, email_terapeuta:string){
    const url = this.servidor+'send-terapeutas.php'; // URL to web api
    const options = new HttpParams()
    .set('nombre', email.nombre)
    .set('apellido', email.apellido)
    .set('celular', email.celular)
    .set('email', email.email)
    .set('mensaje', email.mensaje)
    .set('tipo_de_terapia', email.tipo_de_terapia)
    .set('modalidad', email.modalidad)
    .set('zona', email.zona)
    .set('online', email.online)
    .set('presencial', email.presencial)
    .set('domicilio', email.domicilio)
    .set('acepto', email.acepto)
    .set('email_terapeuta', email_terapeuta)
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
    /*afterNextRender(() => {
      this.dominio = window.location.hostname;
      this.href = window.location.hostname;
      this.protocol = window.location.protocol;

      if(this.href==='localhost'){
        this.servidor = this.protocol+"//"+this.href+'/byontek/server/contact/';
        console.log(this.servidor);
  
      }else{
        this.servidor = this.protocol+"//"+this.href+'/server/contact/';
        console.log(this.servidor);
      }
    });*/
    
  }
}
