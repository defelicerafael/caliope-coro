import { Pipe, PipeTransform } from '@angular/core';
import { Img } from './interface';
import { AdminService } from './admin.service';
import { Observable, Subject } from 'rxjs';

@Pipe({
  name: 'imagenes'
})
export class ImagenesPipe implements PipeTransform {

  constructor(
    private admService:AdminService,
  
  ){}
  
  transform(idImg: string, ...args: unknown[]): Observable<Img> {
    return this.admService.traerImgPorID(idImg);
  }

}
