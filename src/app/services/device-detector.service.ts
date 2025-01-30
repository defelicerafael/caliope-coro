import { Injectable, afterNextRender } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class DeviceDetectorService {
  private isMobileSubject: BehaviorSubject<boolean> = new BehaviorSubject<boolean>(false);
  
  constructor() { 
  
    afterNextRender(() => {
      this.checkWindowSize();
      window.addEventListener('resize', this.onResize.bind(this));
      //console.log('yes');
    });

  }
  private checkWindowSize() {
    const isMobile = window.innerWidth < 768; // Puedes ajustar este valor según tus necesidades
    this.isMobileSubject.next(isMobile);
    //console.log(isMobile);
  }

  private onResize(event: Event) {
    this.checkWindowSize();
  }

  public isMobile(): Observable<boolean> {
    return this.isMobileSubject.asObservable();
  }
}
