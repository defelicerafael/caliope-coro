import { Injectable } from '@angular/core';
import { HttpEvent, HttpInterceptor, HttpHandler, HttpRequest } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable()

export class AuthInterceptor implements HttpInterceptor {
  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    const token = 'D3f3L1C3R4f43lYLuc1l4Alch0ur0nYP1mp0ll1n';  // Tu token aquí

    // Clonar la solicitud para agregar el nuevo encabezado
    const clonedRequest = req.clone({
      //headers: req.headers.set('Authorization', `Bearer ${token}`)
    });

    // Pasar la solicitud clonada al siguiente manejador
    return next.handle(clonedRequest);
  }
}