import { afterNextRender, Component, inject } from '@angular/core';

import { FormControl, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatSelectModule } from '@angular/material/select';
import { AdminService } from '../servicios/admin.service';
import { MatSliderModule } from '@angular/material/slider';
import { provideNativeDateAdapter } from '@angular/material/core';
import { BehaviorSubject, Observable, Subject, Subscription } from 'rxjs';
import { CommonModule, Location } from '@angular/common';
import { MatSnackBar } from '@angular/material/snack-bar';
import { ActivatedRoute } from '@angular/router';

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
    MatSliderModule,
    CommonModule
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
  private _snackBar = inject(MatSnackBar);
  private route = inject(ActivatedRoute);
  public sedes$ :Observable< any > = new Observable; 
  public profes$ :Observable< any > = new Observable; 

  traerSedes(){
      this.sedes$ = this.service.traerSedes('0');
  }
  traerProfes(){
    this.profes$ = this.service.traerProfes('0');
  }


  CalioperosForm = new FormGroup({
      nombre: new FormControl('',[Validators.required, Validators.minLength(3)]),
      apellido: new FormControl('',[Validators.required, Validators.minLength(3)]),
      email: new FormControl('',[Validators.required, Validators.email]),
      celular: new FormControl('',[Validators.required, Validators.minLength(9)]),
      coro: new FormControl('',[Validators.required, Validators.minLength(3)]),
      cuerda: new FormControl('',[Validators.required, Validators.minLength(3)]),
      cuerdasub: new FormControl('',[Validators.required]),
      evaluacion_final: new FormControl('',[Validators.required, Validators.minLength(3)]),
      comentarios: new FormControl(''),
      fecha_de_ingreso: new FormControl('',[Validators.required]),
      vocalizacion: new FormControl('',[Validators.required]),
      armonizacion: new FormControl('',[Validators.required]),
      interpretacion: new FormControl('',[Validators.required]),
      onda: new FormControl('',[Validators.required]),
      traslado: new FormControl('',[Validators.required]),
      profes: new FormControl('',[Validators.required]),
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

  buscarAudicion(id:string){
    if(this.modo ==='editar'){
      this.service.traerIdDelUnaTabla('audiciones',id).subscribe((d:any)=>{
          this.CalioperosForm = new FormGroup({
            nombre: new FormControl(d[0].nombre),
            apellido: new FormControl(d[0].apellido),
            email: new FormControl(d[0].email),
            celular: new FormControl(d[0].celular),
            coro: new FormControl(d[0].coro),
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
            profes: new FormControl(d[0].profes ? d[0].profes.split(",").map((p: string) => p.trim()) : []),
          });
        
        },(error)=>{
          console.log(error,": NO he podido conectarme a ver los vecinos");
        },()=>{});
    }
  }  

  
  onSubmit(formulario:any){
    //console.log(formulario,this.modo,this.tabla);
    this.spinner = true;
    if(this.modo==='agregar'){
       this.service.insertArray(this.tabla,formulario.value).subscribe(respuesta=>{
          //console.log(respuesta);
         if(respuesta===0){
           this.openSnackBar("Hemos ingresado los datos con éxito","Ok");
           this.spinner = false;
           this.goBack();
         }else{
          //console.log(respuesta);
           this.openSnackBar("Estamos teniendo un problema:"+respuesta,"Ok");
           this.spinner = false;
         }
       });
     }else{
      //this.blogForm.get('boton_url')!.setValue(this.transformString(titulo));
      this.service.edit(this.tabla,formulario.value,this.datoId,'id').subscribe(respuesta=>{
        if(respuesta===0){
          this.openSnackBar("SE HA EDITADO CORRECTAMENTE","Ok");
          this.spinner = false;
          this.goBack();
        }else{
          this.openSnackBar("Estamos teniendo un problema, intente más tarde...","Ok");
          this.spinner = false;
        }
      })
    }
  };

  openSnackBar(message: string, action: string) {
    this._snackBar.open(message, action,{
      horizontalPosition: 'center',
      verticalPosition: 'top',
      duration: 4000,
    });
  }

  constructor(){
    
    this.sedes$ = new Subject();
    this.profes$ = new Subject();
    
    afterNextRender(() => {
      this.traerSedes();
      this.traerProfes();
      this.route.params.subscribe( (params) => {
        this.datoId = params['id'];
        console.log(this.tabla,this.datoId);
        if(typeof this.datoId !== 'undefined'){
          if(this.datoId === '0'){
            this.modo='agregar';
            console.log(this.modo);
          }else{
            this.modo='editar';
            console.log(this.modo);
            this.buscarAudicion(this.datoId);
            
          }
        }
      });
    });
  }

}
