import { Routes } from '@angular/router';
import { AdminComponent } from './admin/admin.component';
import { EditProComponent } from './admin/home/edit-pro/edit-pro.component';
import { ShopLoginComponent } from './admin/home/shop-login/shop-login.component';
import { AuthGuard } from './services/auth.guard';
import { ImgCropNewComponent } from './admin/home/img-crop-new/img-crop-new.component';
import { CarouselComponent } from './admin/home/carousel/carousel.component';
import { EditarComponent } from './admin/home/editar/editar.component';

export const routes: Routes = [
    { path: '', component: ShopLoginComponent },
    { path: 'quienes-somos/edit', component: EditarComponent, canActivate: [AuthGuard], pathMatch: 'full' }, // Ruta estática antes de :tabla
    { path: ':tabla', component: AdminComponent, canActivate: [AuthGuard] },
    { path: ':tabla/:datoId', component: EditProComponent, canActivate: [AuthGuard] },
    { path: 'personalizado/:tabla/:datoId', component: EditProComponent, canActivate: [AuthGuard] },
    { path: ':tablaId/:expId/img/:idNueva', component: ImgCropNewComponent, canActivate: [AuthGuard] },
    { path: 'tabla/:tablaId/id/:imgId', component: CarouselComponent, canActivate: [AuthGuard] },
];
