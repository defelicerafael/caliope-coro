import { Routes } from '@angular/router';
import { InsertDataComponent } from './calioperos/insert-data/insert-data.component';
import { HomeComponent } from './calioperos/home/home.component';

export const routes: Routes = [
    { path: 'calioperos/agregar', component: InsertDataComponent },
    { path: 'calioperos', component: HomeComponent },
];
