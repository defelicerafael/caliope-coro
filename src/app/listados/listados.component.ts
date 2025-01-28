import { Component, DestroyRef, Input, OnInit, ViewChild, afterNextRender, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import {MatTableDataSource, MatTableModule} from '@angular/material/table';
import {MatPaginator, MatPaginatorModule} from '@angular/material/paginator';
import { Observable, Subject } from 'rxjs';
import {takeUntilDestroyed} from '@angular/core/rxjs-interop';

import { MatIconModule } from '@angular/material/icon';
import { ActivatedRoute, Router, RouterModule, Routes } from '@angular/router';
import { MatButtonModule } from '@angular/material/button';

import {MatSnackBar} from '@angular/material/snack-bar';
import { AdminService } from '../servicios/admin.service';
import {MatChipsModule} from '@angular/material/chips';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';

@Component({
  selector: 'app-listados',
  standalone: true,
  imports: [
    CommonModule,
    MatTableModule,
    MatPaginatorModule,
    MatIconModule,
    RouterModule,
    MatButtonModule,
    MatChipsModule,
    MatFormFieldModule,
    MatInputModule
  ],
  templateUrl: './listados.component.html',
  styleUrls: ['./listados.component.css']
})
export class ListadosComponent {

  @ViewChild(MatPaginator, { static: false }) paginator!: MatPaginator;
  
  public dataSource = new MatTableDataSource<any>();
  public displayedColumns: any[] = ["id","nombre","apellido","email","celular","evaluacion_final","edit","erase"];
  public tabla:string = "";
  private destroyRef = inject(DestroyRef);
  //public tablaEdit: string[] = ["id","nombre","apellido","email","celular",,"evaluacion_final","edit","erase"];
  
  public adminService = inject(AdminService);
  public columnas$: Observable<any[]> = new Subject();
  public datos$: Observable<any[]> = new Subject();
  public tengolascolumnas:boolean = false;
  public tengolosdatos:boolean = false;


  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
    console.log(this.dataSource.filter);
  }

  borrar(tabla:string,id:string){
    const confirmacion = window.confirm('¿Está seguro de que desea eliminar este dato?');
    if (confirmacion) {
      this.adminService.borrarPorId(tabla,id)
      .subscribe(d=>{
        if(d===0){
          this.datos$ = this.adminService.traerIdDelUnaTabla(this.tabla,'0');
          this.snackBar.open('Se ha borrado correctamente!', 'ok', {
            horizontalPosition: 'center',
            verticalPosition: 'top',
          });
          
        }else{
          this.snackBar.open('No hemos podido borrar el item', 'ok', {
            horizontalPosition: 'center',
            verticalPosition: 'top',
          });
        }
      });
    }
  }

  public obtenerdatos(){
    this.datos$.pipe(takeUntilDestroyed(this.destroyRef)).subscribe((d: any[]) => {
    this.dataSource = new MatTableDataSource(d);

    // Verifica que el paginator esté disponible antes de asignarlo
    if (this.paginator) {
      this.dataSource.paginator = this.paginator;
    }

    this.tengolosdatos = true;
    });
  }

  obtenerTextoLimitado(texto: any): string {
    if (typeof texto === 'string') {
      return texto.slice(0, 100);
    }
    return texto;
  }

  constructor(
    private snackBar: MatSnackBar
  ){
    afterNextRender(() => {
      this.datos$ = this.adminService.traerIdDelUnaTabla('audiciones','0');
      this.obtenerdatos();
    });
  }
  
  

}
