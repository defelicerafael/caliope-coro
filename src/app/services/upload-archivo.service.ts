import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpEventType } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError, map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root',
})

export class UploadService {
    

  //private uploadUrl = 'http://localhost/psicologosenred/psicologosenred/server/upload/upload-archivo.php'; // Cambia esto a la URL de tu backend
  private uploadUrl = 'http://http://psicologosenred.ar/server/upload/upload-archivo.php'; // Cambia esto a la URL de tu backend

  constructor(private http: HttpClient) {
    
  }

  uploadFiles(formData: FormData): Observable<any> {
    return this.http.post<any>(this.uploadUrl, formData, {
      reportProgress: true,
      observe: 'events'
    }).pipe(
      map(event => {
        if (event.type === HttpEventType.UploadProgress && event.total) {
          const percentDone = Math.round((event.loaded / event.total) * 100);
          return { progress: percentDone };
        } else if (event.type === HttpEventType.Response) {
          return event.body;
        }
        return null;
      }),
      catchError(this.handleError)
    );
  }
  
  private handleError(error: HttpErrorResponse) {
    if (error.error instanceof ErrorEvent) {
      // Error del lado del cliente o de red
      console.error('Ocurrió un error:', error.error.message);
    } else {
      // El backend retornó un código de error
      console.error(
        `Backend retornó el código ${error.status}, ` +
        `body was: ${error.error}`);
    }
    // Retorna un observable con un mensaje de error para la app
    return throwError('Algo malo ocurrió; por favor intenta nuevamente más tarde.');
  }
}