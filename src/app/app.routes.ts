import { Routes } from '@angular/router';
import { InsertDataComponent } from './calioperos/insert-data/insert-data.component';
import { HomeComponent } from './calioperos/home/home.component';
import { AudicionesComponent } from './audiciones/audiciones.component';
import { ListadosComponent } from './listados/listados.component';

export const routes: Routes = [
    { path: 'calioperos/agregar', component: InsertDataComponent },
    { path: 'calioperos', component: HomeComponent },
    { path: 'audiciones/id/:id', component: AudicionesComponent },
    { path: 'audiciones', component: ListadosComponent },
];
