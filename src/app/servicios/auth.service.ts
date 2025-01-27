import { Injectable, NgZone } from '@angular/core';
import { Router } from '@angular/router';
import { HttpClient,HttpParams } from '@angular/common/http';
import { AdminService } from './admin.service';
import { MatSnackBar } from '@angular/material/snack-bar';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
    public userData: any; 
    public soyUsuario:number = 0; 
    public href: string = '';
    public servidor:string= '';  
   
    constructor(
        public router: Router,
        public ngZone: NgZone,
        private http: HttpClient,
        private _snackBar: MatSnackBar, 
        private admService:AdminService
        
    ) {
        this.servidor = this.admService.servidor;
    }
    public SetUserData(user:any){
        if(user.user){
            this.userData = user;
            localStorage.setItem('user', JSON.stringify(user));
            JSON.parse(localStorage.getItem('user')!);
            let msj = "Bienvenido/a, Será reenviado en breve...";
            let button = "Ok";
            this._snackBar.open(msj, button,{
                horizontalPosition: 'center',
                verticalPosition: 'top',
                duration: 4000,
            });
            this.ngZone.run(() => {
                this.router.navigate(['admin/tabla/blog'], {
                    state: { tabla: 'blog' }
                });
            });
        }else {
            localStorage.setItem('user', 'null');
            let msj = "No coinciden el usuario y la contraseña...";
            let button = "Ok";
            this._snackBar.open(msj, button,{
                horizontalPosition: 'center',
                verticalPosition: 'top',
                duration: 4000,
            });
            JSON.parse(localStorage.getItem('user')!);
        }
    }
  
    public SetUserDataUsuarios(user:any){
        if(user.user){
            this.userData = user;
            localStorage.setItem('user', JSON.stringify(user));
            JSON.parse(localStorage.getItem('user')!);
            let msj = "Bienvenido/a, Será reenviado en breve...";
            let button = "Ok";
                this._snackBar.open(msj, button,{
                    horizontalPosition: 'center',
                    verticalPosition: 'top',
                    duration: 4000,
                });
            this.ngZone.run(() => {
                this.router.navigate(['tabla/bio']);
            });
        }else {
            localStorage.setItem('user', 'null');
            let msj = "No coinciden el usuario y la contraseña...";
            let button = "Ok";
            this._snackBar.open(msj, button,{
                horizontalPosition: 'center',
                verticalPosition: 'top',
                duration: 4000,
            });
            JSON.parse(localStorage.getItem('user')!);
        }
    }
// Returns true when user is looged in and email is verified
    get isLoggedIn(): boolean {
        const user = JSON.parse(localStorage.getItem('user')!);
        if(user!==null){
            return user !== null ? true : false;
        }else{
            return false;
        }
    }

    get isLoggedInUsers(): boolean {
        const user = JSON.parse(localStorage.getItem('user')!);
        if(user!==null){
            return user !== null ? true : false;
        }else{
            return false;
        }
    }

  // Sign out
    logout() {
        localStorage.removeItem('user');
        this.ngZone.run(() => {
            this.router.navigate(['admin']);
        });
    }
    logoutusers() {
        localStorage.removeItem('user');
        this.ngZone.run(() => {
            this.router.navigate(['admin']);
        });
    }
  // VERIFICAR USUARIO //
    login(email:string,pass:string){
        //console.log(email,pass);
        const url = this.servidor+'login.php'; // URL to web api
        const options = new HttpParams()
        .set('user', email)
        .set('pass',pass)
        ;
        return this.http.post(url,options);
    }
    loginUsuarios(email:string,pass:string){
        //console.log(email,pass);
        const url = this.servidor+'loginUsuarios.php'; // URL to web api
        const options = new HttpParams()
        .set('user', email)
        .set('pass',pass)
        ;
        return this.http.post(url,options);
    }
}