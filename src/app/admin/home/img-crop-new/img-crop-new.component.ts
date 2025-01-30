import { afterNextRender, Component, OnInit, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DomSanitizer } from '@angular/platform-browser';
import { ToolbarComponent } from '../toolbar/toolbar.component';

import { ActivatedRoute } from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';
import { RouterModule } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { Location } from '@angular/common';
import { ImageCropperComponent } from 'ngx-image-cropper';
import { ImageCroppedEvent, LoadedImage } from 'ngx-image-cropper';
import { AdminService } from '../../../services/admin.service';

import {MatInputModule} from '@angular/material/input';
import {MatSelectModule} from '@angular/material/select';
import {MatFormFieldModule} from '@angular/material/form-field';
import {FormsModule} from '@angular/forms';
import {MatButtonModule} from '@angular/material/button';
import {MatIconModule} from '@angular/material/icon';
import {MatTooltipModule} from '@angular/material/tooltip';

@Component({
    selector: 'app-img-crop-new',
    standalone: true,
    imports: [
        CommonModule,
        ImageCropperComponent,
        ToolbarComponent,
        RouterModule,
        MatSelectModule,
        MatFormFieldModule,
        FormsModule,
        MatInputModule,
        MatButtonModule,
        MatIconModule,
        MatTooltipModule
    ],
    templateUrl: './img-crop-new.component.html',
    styleUrls: ['./img-crop-new.component.css'],
    host: { ngSkipHydration: 'true' }
})
export class ImgCropNewComponent implements OnInit{
  
  public imageChangedEvent: any = '';
  public croppedImage: any = '';
  public croppedImageBlob : any = '';
  public radioAspect:number = 19/16;
  public calidad:number = 100;
  public crop:string = "nueva";
  public idTabla:any = "";
  public tabla:any = "";
  public ImgCargada:any[] = [];
  public width: number = 0;
  public heigth: number = 0;

  public mostrarUpload = signal<boolean>(false);
  public mostrarGuardar = signal<boolean>(false);
  public mostrarEditar = signal<boolean>(false);
  
 
  constructor(
    private sanitizer: DomSanitizer,
    private route: ActivatedRoute,
    private service: AdminService,
    private _snackBar: MatSnackBar,
    private http: HttpClient,
    private location: Location
  ) {

    
  }


  public aspectRatio:any[] = [
    {
      "aspect":1 / 1, "value":"1/1"
    },
    {
      "aspect":3 / 2, "value":"3/2"
    },
    {
      "aspect":4 / 3, "value":"4/3"
    },
    {
      "aspect":5 / 4, "value":"5/4"
    },
    {
      "aspect":14 / 19, "value":"14/19"
    },
    { 
      "aspect":16 / 9, "value":"16/9"
    },
    { 
      "aspect":21 / 9, "value":"21/9" 
    },
    { 
      "aspect":16 / 10, "value":"16/10"
    },
    {
      "aspect":16 / 19, "value":"16/19"
    },
    {
      "aspect":9 / 16, "value":"9/16"
    },
    {
      "aspect":10 / 16, "value":"10/16"
    },
    {
      "aspect":2 / 1, "value":"2/1"
    }
  ];

  setRatio(e:any){
    console.log(e);
    this.radioAspect = e;
    console.log(this.radioAspect)
  }
  setCalidad(e:any){
    this.calidad = e.target.value;
  }

  fileChangeEvent(event: any): void {
      this.imageChangedEvent = event;
      console.log(this.imageChangedEvent);
  }
  

  imageCropped(event: ImageCroppedEvent) {
    //console.log(event);
    if (event.objectUrl) {
      
      this.croppedImage = this.sanitizer.bypassSecurityTrustUrl(event.objectUrl);
  
      // Fetch the image data from the objectUrl
      this.http.get(event.objectUrl, { responseType: 'blob' }).subscribe((blob: Blob) => {
        const reader = new FileReader();
        reader.onloadend = () => {
          // The result of the FileReader contains the base64-encoded image data
          this.croppedImageBlob = reader.result as string;
          //console.log(this.croppedImageBlob);
        };
        reader.readAsDataURL(blob);
      });
    }
    // event.blob can be used to upload the cropped image
  }


  imageLoaded(image: LoadedImage) {
    console.log("imageLoad");
    if(this.crop === 'nueva'){
      this.mostrarUpload.set(false); 
      this.mostrarGuardar.set(true); 
      this.mostrarEditar.set(false); 
    }else{
      this.mostrarEditar.set(true); 
      this.mostrarGuardar.set(false); 
      this.mostrarUpload.set(false); 
    }
  }
  cropperReady() {    
  }

  loadImageFailed() {
      // show message
  }

  guardarImg(){
    this.openSnackBar("Guardando...","Ok");
    //console.log(this.cargoImg);
    if(this.crop==='crop'){
     // console.log("ya tiene foto");
      this.service.GuardarImg(this.tabla,this.idTabla,this.croppedImageBlob)
      .subscribe(d=>{
        if(d == 1){
          this.openSnackBar("Hemos tenido un error tratando de editar su imagen","Ok");
        }else{
          this.openSnackBar("Su imagen ha sido actualizada correctamente","Ok");
          this.goBack();
        }
        
      })
    }
    if(this.crop==='nueva'){
      console.log("entre a nuevo");
      this.service.GuardarImgEnCarousel(this.idTabla,this.croppedImageBlob)
      .subscribe(d=>{
        console.log(d);
        this.openSnackBar("Su imagen ha sido ingresada correctamente","Ok");
        this.goBack();
      })
    }
  }

  openSnackBar(message: string, action: string) {
    this._snackBar.open(message, action,{
      horizontalPosition: 'center',
      verticalPosition: 'top',
      duration: 4000,
    });
  }

  goBack() {
    this.location.back();
  }

  reemplazarFoto(){
    this.mostrarUpload.set(true); 
    console.log(this.mostrarUpload());
  }
  
  eliminarFoto(){
    this.mostrarUpload.set(false); 
  }

  ngOnInit(){
    this.route.params.subscribe( (params) => {
      console.log(params);
      this.idTabla = params['expId'];
      this.tabla = params['tablaId'];
      this.crop = params['idNueva'];
      if(this.crop === 'crop'){
        this.service.traerImgPorIdObs(this.idTabla,this.tabla).subscribe(img=>{
          if(img.length !== 0){
            console.log(img);
            this.ImgCargada[0] = img;
            console.log(this.ImgCargada[0]?.img);
            this.mostrarUpload.set(false);
            this.mostrarGuardar.set(false);
            this.mostrarEditar.set(true);
            console.log(this.ImgCargada[0].img);
            this.imageLoaded(this.ImgCargada[0]);
          }
        })
      }
      if(this.crop === 'nueva'){
        this.mostrarUpload.set(true);
        this.mostrarGuardar.set(false);
        this.mostrarEditar.set(false);
      }
    });
  }
  
}
