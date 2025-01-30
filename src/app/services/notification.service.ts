import { inject, Injectable } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class NotificationService {
  private notificationSubject = new Subject<string>();
  private diaCompleto = new Subject<string>();

  private _snackBar = inject(MatSnackBar);

  notification$ = this.notificationSubject.asObservable();
  diaCompleto$ = this.notificationSubject.asObservable();

  openSnackBar(message: string, action: string) {
    this._snackBar.open(message, action);
  }

  completarDia(message: string) {
    this.notificationSubject.next(message);
  }





}