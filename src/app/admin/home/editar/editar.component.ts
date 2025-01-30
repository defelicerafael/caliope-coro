import { Component, OnInit, signal } from '@angular/core';
import {  RouterModule } from '@angular/router';

import { UntypedFormGroup,UntypedFormControl, ReactiveFormsModule } from '@angular/forms';
import { MatSnackBar, MatSnackBarModule } from '@angular/material/snack-bar';
import { CommonModule, Location } from '@angular/common';

import { AdminService } from '../../../services/admin.service';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatSelectModule } from '@angular/material/select';
import { QuillModule } from 'ngx-quill'
import { QuillEditorComponent } from 'ngx-quill'


@Component({
  selector: 'app-editar',
  standalone: true,
  imports: [
    CommonModule,
    ReactiveFormsModule,
    RouterModule,
    MatSnackBarModule,
    MatFormFieldModule,
    MatSelectModule,
    QuillModule,
    QuillEditorComponent
  ],
  templateUrl: './editar.component.html',
  styleUrls: ['./editar.component.css']
})
export class EditarComponent implements OnInit {
  
  public id: string = "0" ;
  public tabla: string = "quienes_somos";
  public mostrarForm = signal<boolean>(false);
  
  public novedadesForm = new UntypedFormGroup({
    texto: new UntypedFormControl(''),
    mostrar: new UntypedFormControl(''),
  });


  switchTabla(){
    this.service.edit(this.tabla,this.novedadesForm.value,'1','id').subscribe(respuesta=>{
      if(respuesta===0){
        this.openSnackBar("Ha sido editado correctamente","Ok");
        this.goBack();
      }else{
        this.openSnackBar("Estamos teniendo un problema, intente más tarde...","Ok");
      }
    })
  }
  /* EVENTOS FORM */
  openSnackBar(message: string, action: string) {
    this._snackBar.open(message, action,{
      horizontalPosition: 'center',
      verticalPosition: 'top',
      duration: 4000,
    });
  }

  goBack() {
    this.location.back();
  }
  
  onSubmit() {
    this.switchTabla();
  }


  constructor(
    private service: AdminService,
    private location: Location,
    private _snackBar: MatSnackBar,
    
  ) {}

  public ngOnInit() {
    this.service.traerIdDelUnaTabla(this.tabla,this.id,'DESC','id')
    .subscribe(d=>{
      //console.log(d);
      if(d.length!==0){
        this.mostrarForm.set(true);
        this.novedadesForm = new UntypedFormGroup({
          texto: new UntypedFormControl(d[0].texto),
          mostrar: new UntypedFormControl(d[0].mostrar),
        });
        console.log(this.novedadesForm.value);
      }
    })
  }

  
}

  

