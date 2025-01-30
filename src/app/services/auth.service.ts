import { afterNextRender, inject, Inject, Injectable, PLATFORM_ID } from '@angular/core';
import { Router } from '@angular/router';
import { HttpClient, HttpParams } from '@angular/common/http';
import { AdminService } from './admin.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { isPlatformBrowser } from '@angular/common';
import { ResourcesService } from './resources.service';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
    public userData: any; 
    public soyUsuario:number = 0; 
    public href: string = '';
    public servidor:string= '';
    public resoursesService = inject(ResourcesService); 
    public fechaActual:any = '';
    
    constructor(
        public router: Router,
        private http: HttpClient,
        private _snackBar: MatSnackBar, 
        private admService:AdminService,
        @Inject(PLATFORM_ID) private platformId: Object
        
    ) {
        afterNextRender(async () => {
            this.servidor = this.admService.servidor;
            this.resoursesService.obtenerFecha().subscribe(fecha => {
                this.fechaActual = fecha;
            });
        });
        
    }
    public SetUserData(user:any){
        if (isPlatformBrowser(this.platformId)) {
            if(user.user){
                this.userData = user;
                sessionStorage.setItem('user', JSON.stringify(user));
                JSON.parse(sessionStorage.getItem('user')!);
                let msj = "Bienvenido/a, Será reenviado en breve...";
                let button = "Ok";
                this._snackBar.open(msj, button,{
                    horizontalPosition: 'center',
                    verticalPosition: 'top',
                    duration: 4000,
                });
                
                console.log('entre acá...');
                /*this.router.navigate(
                    [{ outlets: { home: ['fecha', this.fechaActual.dia, this.fechaActual.mes, this.fechaActual.año] } }],
                );*/
                this.router.navigate(['home/fecha/'+this.fechaActual.dia+'/'+this.fechaActual.mes+'/'+this.fechaActual.anio], {
                    //state: { tabla: 'resources' }
                });
                
            }else {
                sessionStorage.setItem('user', 'null');
                let msj = "No coinciden el usuario y la contraseña...";
                let button = "Ok";
                this._snackBar.open(msj, button,{
                    horizontalPosition: 'center',
                    verticalPosition: 'top',
                    duration: 4000,
                });
                JSON.parse(sessionStorage.getItem('user')!);
            }
        }
    }
  
    public SetUserDataAdmin(user:any){
        if (isPlatformBrowser(this.platformId)) {
            if(user.user){
                this.userData = user;
                console.log(this.userData);
                sessionStorage.setItem('userAdmin', JSON.stringify(user));
                JSON.parse(sessionStorage.getItem('userAdmin')!);
                let msj = "Bienvenido/a, Será reenviado en breve...";
                let button = "Ok";
                this._snackBar.open(msj, button,{
                    horizontalPosition: 'center',
                    verticalPosition: 'top',
                    duration: 4000,
                });
               
                console.log("entre acá...");
                    this.router.navigate(['calioperos'], {
                });
                
            }else {
                sessionStorage.setItem('user', 'null');
                let msj = "No coinciden el usuario y la contraseña...";
                let button = "Ok";
                this._snackBar.open(msj, button,{
                    horizontalPosition: 'center',
                    verticalPosition: 'top',
                    duration: 4000,
                });
                JSON.parse(sessionStorage.getItem('userAdmin')!);
            }
        }
    }
// Returns true when user is looged in and email is verified
    get isLoggedIn(): boolean {
        if (isPlatformBrowser(this.platformId)) {
            const user = JSON.parse(sessionStorage.getItem('user')!);
            if (user !== null) {
                return true;
            }
        }
        return false;
    }

    get isLoggedInAdmin(): boolean {
        if (isPlatformBrowser(this.platformId)) {
            const user = JSON.parse(sessionStorage.getItem('userAdmin')!);
            //console.log(user);
            if (user !== null) {
                return true;
            }
        }
        return false;
    }

  // Sign out
    logout() {
        console.log("nos fuimos");
        if (isPlatformBrowser(this.platformId)) {
            sessionStorage.removeItem('user');
            
            this.router.navigate(['/']);
            
        }
    }
    logoutAdmin() {
        if (isPlatformBrowser(this.platformId)) {
            sessionStorage.removeItem('userAdmin');
            
            this.router.navigate(['admin']);
            
        }
    }
  // VERIFICAR USUARIO //
    login(email:string,pass:string){
        //console.log(email,pass);
        const url = this.servidor+'login/login.php'; // URL to web api
        const options = new HttpParams()
        .set('user', email)
        .set('pass',pass)
        .set('tipo_de_usuario','empleados')
        ;
        return this.http.post(url,options);
    }
    
    loginAdmin(email:string,pass:string){
        //console.log(email,pass);
        const url = this.servidor+'login/login-admin.php'; // URL to web api
        const options = new HttpParams()
        .set('user', email)
        .set('pass',pass)
        ;
        return this.http.post(url,options);
    }
}