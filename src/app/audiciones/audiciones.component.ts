import { Component } from '@angular/core';
import { AdminService } from '../servicios/admin.service';
import { FormControl, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatSelectModule } from '@angular/material/select';

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
    MatButtonModule
  ],
  templateUrl: './audiciones.component.html',
  styleUrl: './audiciones.component.css'
})
export class AudicionesComponent {
  CalioperosForm = new FormGroup({
      nombre: new FormControl('',[Validators.required, Validators.minLength(3)]),
      apellido: new FormControl('',[Validators.required, Validators.minLength(3)]),
      email: new FormControl('',[Validators.required, Validators.email]),
      celular: new FormControl('',[Validators.required, Validators.minLength(9)]),
      pass: new FormControl('',[Validators.required, Validators.minLength(3)]),
      cuerda: new FormControl('',[Validators.required, Validators.minLength(3)]),
      cuerdasub: new FormControl('',[Validators.required, Validators.minLength(3)]),
      activo: new FormControl('',[Validators.required, Validators.minLength(3)]),
      comentarios: new FormControl(''),
      fecha_de_ingreso: new FormControl('',[Validators.required]),
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
    
  constructor(private adminService: AdminService) {}
}
