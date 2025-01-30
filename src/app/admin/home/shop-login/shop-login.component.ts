import { afterNextRender, Component, Inject, OnInit, PLATFORM_ID } from '@angular/core';
import { CommonModule, isPlatformBrowser } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ReactiveFormsModule } from '@angular/forms';
import { FormControl,FormGroup, Validators } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { RouterModule } from '@angular/router';
import { AuthService } from '../../../services/auth.service';


@Component({
    selector: 'app-shop-login',
    standalone: true,
    imports: [
      CommonModule,
      FormsModule,
      ReactiveFormsModule,
      RouterModule,
      MatButtonModule
    ],
    templateUrl: './shop-login.component.html',
    styleUrls: ['./shop-login.component.css']
})
export class ShopLoginComponent implements OnInit {

  public loginForm:any = "";
  public mensaje:any = "";
  public modal: boolean = true;
  public userLogin:any = "";
  public userObj:object = {};
  public ver:boolean = false;
  public inputType: string = "password";
  get user() { return this.loginForm.get('user'); }
  get pass() { return this.loginForm.get('pass'); }
  
  constructor(
    private authService:AuthService,
    @Inject(PLATFORM_ID) private platformId: Object
  ) { 
    afterNextRender(() => {
      this.estaLogueado();
    });
  }
  

  togglePassword() {
    this.ver = !this.ver;
    this.inputType = (this.inputType === 'password') ? 'text' : 'password';
  } 

  

  estaLogueado():any{
    if (isPlatformBrowser(this.platformId)) {
      if(localStorage.getItem('userAdmin')){
        this.userLogin = localStorage.getItem('userAdmin');
        this.userObj = JSON.parse(this.userLogin).user;
        console.log('esta logueado');
        return true;
      }else{
        return false;
      }
    }
  }

  login(): void {
    
    this.authService.loginAdmin(this.user.value, this.pass.value).subscribe((d: any) => {
      if (d.length == 0) {
        this.mensaje = " No coinciden el usuario con la contraseña...";
      } else {
        this.modal = false;
        this.authService.SetUserDataAdmin(d);
      }
    });
  }

    onSubmit(): void {
      this.loginForm.reset();
    }

    ngOnInit(): void {
      this.loginForm = new FormGroup({
        user: new FormControl('',[Validators.required]),
        pass: new FormControl('',[Validators.required]),
    });
  }

}
