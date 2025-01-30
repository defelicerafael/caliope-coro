import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ShowloginService {

  private loginOnSubject = new BehaviorSubject<boolean>(false);
  loginOn$ = this.loginOnSubject.asObservable();

  logOn() {
    const currentState = this.loginOnSubject.getValue();
    this.loginOnSubject.next(!currentState);
    //console.log('Login state changed:', !currentState);
  }

  
}
