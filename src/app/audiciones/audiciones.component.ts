import { Component, inject } from '@angular/core';

import { FormControl, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatSelectModule } from '@angular/material/select';
import { AdminService } from '../servicios/admin.service';
import { MatSliderModule } from '@angular/material/slider';
import { provideNativeDateAdapter } from '@angular/material/core';
import { Subscription } from 'rxjs';
import { Location } from '@angular/common';

@Component({
  selector: 'app-audiciones',
  standalone: true,
  imports: [
    MatInputModule,
    MatFormFieldModule,
    ReactiveFormsModule,
    FormsModule,
    MatSelectModule,
    MatDatepickerModule,
    MatButtonModule,
    MatSliderModule
  ],
  providers: [provideNativeDateAdapter()],
  templateUrl: './audiciones.component.html',
  styleUrl: './audiciones.component.css'
})
export class AudicionesComponent {

  public max:number = 100;
  public min:number = 1;
  public step:number = 1;
  public modo:string = "";
  public miSubscription: Subscription | undefined;
  public spinner:boolean = false;
  public tabla:string = "audiciones";
  public datoId:string = "";
  private service = inject(AdminService);
  private location = inject(Location);
 

  CalioperosForm = new FormGroup({
      nombre: new FormControl('',[Validators.required, Validators.minLength(3)]),
      apellido: new FormControl('',[Validators.required, Validators.minLength(3)]),
      email: new FormControl('',[Validators.required, Validators.email]),
      celular: new FormControl('',[Validators.required, Validators.minLength(9)]),
      coro: new FormControl('',[Validators.required, Validators.minLength(3)]),
      cuerda: new FormControl('',[Validators.required, Validators.minLength(3)]),
      cuerdasub: new FormControl('',[Validators.required, Validators.minLength(3)]),
      evaluacion_final: new FormControl('',[Validators.required, Validators.minLength(3)]),
      comentarios: new FormControl(''),
      fecha_de_ingreso: new FormControl('',[Validators.required]),
      vocalizacion: new FormControl('',[Validators.required]),
      armonizacion: new FormControl('',[Validators.required]),
      interpretacion: new FormControl('',[Validators.required]),
      onda: new FormControl('',[Validators.required]),
      traslado: new FormControl('',[Validators.required]),
    });
  
  
    get nombre() {
      return this.CalioperosForm.get('nombre');
    }
    get apellido() {
      return this.CalioperosForm.get('apellido');
    }
    get email() {
      return this.CalioperosForm.get('email');
    }
    get celular() {
      return this.CalioperosForm.get('celular');
    }
    get pass() {
      return this.CalioperosForm.get('pass');
    }
    get cuerda() {
      return this.CalioperosForm.get('cuerda');
    }
  
    get cuerdasub() {
      return this.CalioperosForm.get('cuerdasub');
    }
  
    get comentarios() {
      return this.CalioperosForm.get('comentarios');
    }
    get fecha_de_ingreso() {
      return this.CalioperosForm.get('fecha_de_ingreso');
    }
    
  

  goBack() {
    this.location.back();
  }

  buscarAudicion(tabla:string,id:string){
    if(this.modo ==='editar'){
      this.miSubscription =  this.service.traerIdDelUnaTabla(tabla,id).subscribe(d=>{
       
          this.CalioperosForm = new FormGroup({
            nombre: new FormControl(d[0].nombre),
            apellido: new FormControl(d[0].apellido),
            email: new FormControl(d[0].email),
            celular: new FormControl(d[0].celular),
            coro: new FormControl(d[0].pass),
            cuerda: new FormControl(d[0].cuerda),
            cuerdasub: new FormControl(d[0].cuerdasub),
            evaluacion_final: new FormControl(d[0].evaluacion_final),
            comentarios: new FormControl(d[0].comentarios),
            fecha_de_ingreso: new FormControl(d[0].fecha_de_ingreso),
            vocalizacion: new FormControl(d[0].vocalizacion),
            armonizacion: new FormControl(d[0].armonizacion),
            interpretacion: new FormControl(d[0].interpretacion),
            onda: new FormControl(d[0].onda),
            traslado: new FormControl(d[0].traslado),
          });
        
        },(error)=>{
          console.log(error,": NO he podido conectarme a ver los vecinos");
        },()=>{});
    }
  }  

}
