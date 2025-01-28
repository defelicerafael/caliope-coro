import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse,HttpParams } from '@angular/common/http';
import { catchError,Observable,throwError} from 'rxjs';
import {debounceTime, distinctUntilChanged, map, startWith, tap } from 'rxjs/operators';
import { Img } from './interface';
//import { EmailAsociado } from '../servicios/email';
import { Location } from '@angular/common';


@Injectable({
  providedIn: 'root'
})
export class AdminService {
 
  public href: string = '';
  public protocol: string = '';
  public servidor:string= '';  
  public loading:boolean = false;
  public loader:boolean = false;
  
  constructor(
    private http: HttpClient,
    private location: Location,
    
  ) { 
    if (typeof window !== "undefined") {
      this.href = window.location.hostname;
      this.protocol = window.location.protocol;
      console.log(this.protocol+this.href);
    }
    

    if(this.href==='localhost'){
      this.servidor = this.protocol+"//"+this.href+'/caliope-app/server/';
      //console.log(this.servidor);
    }else{
      this.servidor = this.protocol+"//"+this.href+'/server/';
      //console.log(this.servidor);
    }
  }
  private handleError(error: HttpErrorResponse) {
    
    if (error.status === 0) {
      // A client-side or network error occurred. Handle it accordingly.
      console.error('An error occurred:', error.error);
      //this.loading = false;
    } else {
      // The backend returned an unsuccessful response code.
      // The response body may contain clues as to what went wrong.
     // this.loading = false;
      console.error(
        `Backend returned code ${error.status}, body was: `, error.error);
    }
    // Return an observable with a user-facing error message.
    //this.loading = false;
    return throwError(() => new Error('Something bad happened; please try again later.'));
  } 

  traerColumnasTabla(tabla:string):Observable<any[]>{
    const url = this.servidor+'traer-columnas-de-tabla.php?tabla='+tabla;  // URL to web api
    return this.http.get<any[]>(url)
    .pipe(
      tap(data=>{
        //console.log(data);
      }),
      map(resp=>{
        return resp;
      }),
      debounceTime(1500),
      distinctUntilChanged(),
      startWith([]),
      catchError(this.handleError),
    );
  }


  traerIdDelUnaTabla(tabla:string,id:string):Observable<any[]>{
    //console.log(tabla,id);
    const url = this.servidor+'traer-tabla-por-id.php?tabla='+tabla+"&id="+id;  // URL to web api
    return this.http.get<any[]>(url)
    .pipe(
      tap(data=>{
       //console.log(data);
      }),
      map(resp=>{
        return resp;
      }),
      debounceTime(500),
      distinctUntilChanged(),
      startWith([]),
      catchError(this.handleError),
    );
  }
  traerAlgoDeUnaTabla(tabla:string,columna:string,que:string,filtro:string,orden:string,limit:string):Observable<any[]>{
    //console.log(tabla,columna,que);
    const url = this.servidor+'traer-tabla.php?tabla='+tabla+"&columna="+columna+"&que="+que+"&filtro="+filtro+"&orden="+orden+"&limit="+limit;  // URL to web api
    return this.http.get<any[]>(url)
    .pipe(
      tap(data=>{
        //console.log(data);
      }),
      map(resp=>{
        return resp;
      }),
      debounceTime(500),
      distinctUntilChanged(),
      startWith([]),
      catchError(this.handleError),
    );
  }

  traerImgPorID(id:string){
    const url = this.servidor+'traer-img-por-id.php?id='+id;  // URL to web api
    return this.http.get<Img>(url)
    .pipe(
      tap(data=>{
       // console.log(data);
      }),
      map(resp=>{
        return resp;
      }),
      debounceTime(500),
      distinctUntilChanged(),
      startWith([]),
      catchError(this.handleError),
    );
  }

  

  borrarPorId(tabla:string,id:string){
    const url = this.servidor+'borrar-por-id.php?tabla='+tabla+"&id="+id;  // URL to web api
    return this.http.get(url)
    .pipe(
      tap(data=>{
        //console.log(data);
      }),
      map(resp=>{
        return resp;
      }),
      debounceTime(500),
      distinctUntilChanged(),
      startWith([]),
      catchError(this.handleError),
    );
  }
  
  insertArray(tabla:string, data:Img[]  | any){
    //console.log(tabla, data);
    const url = this.servidor+'insert_array.php'; // URL to web api
    const options = new HttpParams()
      .set('tabla', tabla)
      .set('datos',JSON.stringify(data))
    ;
    return this.http.post(url,options)
      .pipe(
        catchError(this.handleError)
      ).pipe(
        tap(
          val=>{
            this.loading = false;
            //console.log(val);
            }
          )
      );
  }

  

  edit(tabla:string, data:any, id:string, where:string){
   // console.log(tabla,data,id,where);
    const url = this.servidor+'edit.php'; // URL to web api
    const options = new HttpParams()
      .set('tabla', tabla)
      .set('datos',JSON.stringify(data))
      .set('id',id)
      .set('where',where)
    ;
    return this.http.post(url,options)
      .pipe(
        catchError(this.handleError)
      ).pipe(
        tap(
          val=>{this.loading = false;}
          )
      );
  }
  
  editar(tabla:string, que:string,valor:string, id:string, where:string){
    
    const url = this.servidor+'editar.php'; // URL to web api
    const options = new HttpParams()
      .set('tabla', tabla)
      .set('que',que)
      .set('valor',valor)
      .set('id',id)
      .set('where',where)
    ;
    return this.http.post(url,options)
      .pipe(
        catchError(this.handleError)
      ).pipe(
        tap(
          val=>{this.loading = false;}
          )
      );
  }

  GuardarImg(tabla:string,idTabla:string,base:string){
    //console.log(tabla,idTabla,base);  
    tabla = tabla.trim();
    idTabla = idTabla.trim();
       
    const url = this.servidor+'guardar-editar-img.php';  // URL to web api
    
    const options = new HttpParams()
      .set('tabla', tabla)
      .set('id_tabla',idTabla)
      .set('base',btoa(base));
    ;
    //console.log(options);
    return this.http.post(url,options)
      .pipe(
        catchError(this.handleError)
      );
  }
  
  GuardarImgEnCarousel(idTabla:string,base:string){
     const url = this.servidor+'guardar-img-carousel.php';  // URL to web api
     const options = new HttpParams()
       .set('id_tabla',idTabla)
       .set('base',btoa(base));
     return this.http.post(url,options)
       .pipe(
         catchError(this.handleError)
       );
  }

  
 
  traerImgPorIdObs(id:string):Observable<Img[]>{
    const url = this.servidor+'traer-img-por-id.php?id='+id;  // URL to web api
    return this.http.get<Img[]>(url)
    .pipe(
      tap(data=>{
        //console.log(data);
      }),
      map(resp=>{
        return resp;
      }),
      debounceTime(500),
      distinctUntilChanged(),
      startWith([]),
      catchError(this.handleError),
    );
  }

  editarOrden(tabla:string,id:string,orden:string){
    //console.log(tabla, id, orden);
    const url = this.servidor+'cambiar-orden.php?tabla='+tabla+'&id='+id+'&orden='+orden;  // URL to web api
    return this.http.get<number>(url)
    .pipe(
      tap(
        val=>{this.loading = false;}
        )
    );
  }
 
    
  goBack() {
    this.location.back();
  }
 
  
  traerArticulosPorCategoriaOrden(id:string,orden:string,direccion:string){
    
    this.loader = true;
    const url = this.servidor+'shop/traer-articulos-por-categoria-y-orden.php?id='+id+'&orden='+orden+'&orden='+direccion;  // URL to web api
    return this.http.get<any[]>(url)
    .pipe(
      tap(data=>{
        //console.log(data);
      }),
      map(resp=>{
        return resp;
      }),
      debounceTime(500),
      distinctUntilChanged(),
      startWith([]),
      catchError(this.handleError),
    );
  }


  traerCategorias(id:string){
    this.loader = true;
    const url = this.servidor+'shop/traer-categorias.php?id='+id;  // URL to web api
    return this.http.get<any[]>(url)
    .pipe(
      tap(data=>{
        //console.log(data);
      }),
      map(resp=>{
        return resp;
      }),
      debounceTime(500),
      distinctUntilChanged(),
      startWith([]),
      catchError(this.handleError),
    );
  }
  traerUnicos(tabla:string,columna:string){
    this.loader = true;
    const url = this.servidor+'shop/traer-columna-unique.php?tabla='+tabla+'&columna='+columna;  // URL to web api
    return this.http.get<any[]>(url)
    .pipe(
      tap(data=>{
       // console.log(data);
      }),
      map(resp=>{
        return resp;
      }),
      debounceTime(500),
      distinctUntilChanged(),
      startWith([]),
      catchError(this.handleError),
    );
  }


  traerArticulosMostrarSi(){
    this.loader = true;
    const url = this.servidor+'shop/traer-articulos-mostrar-si.php';  // URL to web api
    return this.http.get<any[]>(url)
    .pipe(
      map((elementos:any[])=>{
        return elementos.map(elementos=>({
          coloresArray : elementos.colores.split(","),
          colores:elementos.colores,
          id:elementos.id,
          img:elementos.img,
          nombre:elementos.nombre,
          precio:elementos.precio,
          descripcion:elementos.descripcion,
          medidas:elementos.medidas,
          lavado:elementos.lavado,
          caracteristicas:elementos.caracteristicas,
          mostrar:elementos.mostrar,
          orden:elementos.orden,
          stock:elementos.stock,
          stockArray:elementos.stock.split(","),
        }))
      }),
      catchError(this.handleError),
      tap(()=>{this.loader = false;})
    );
  }

  traerOpciones(id:string){
    this.loader = true;
    const url = this.servidor+'shop/traer-opciones.php?id='+id;  // URL to web api
    return this.http.get<any[]>(url)
    .pipe(
      catchError(this.handleError),
      tap(()=>{this.loader = false;})
    );
  }
  traerOpcionesNombreOpcion(id:string){
    this.loader = true;
    const url = this.servidor+'shop/traer-opciones-nombre-opcion.php?id='+id;  // URL to web api
    return this.http.get<any[]>(url)
    .pipe(
      catchError(this.handleError),
      tap(()=>{this.loader = false;})
    );
  }
  
  traerArticulosPorBusqueda(tabla:string,palabra:string){
    this.loader = true;
    const url = this.servidor+'shop/traer-articulos-like-new.php?tabla='+tabla+'&palabra='+palabra;  // URL to web api
    return this.http.get<any[]>(url)
    .pipe(
      catchError(this.handleError),
      tap(()=>{this.loader = false;})
    );
  }
  traerArticulosPorBusquedaQue(tabla:string,que:string,palabra:string){
    this.loader = true;
    const url = this.servidor+'shop/traer-articulos-like-que.php?tabla='+tabla+'&palabra='+palabra+'&que='+que;  // URL to web api
    return this.http.get<any>(url)
    .pipe(
      catchError(this.handleError),
      tap((data)=>{
        //console.log(data);
        this.loader = false;})
    );
  }


  traerArticulosPorBusquedaSinLike(tabla:string,que:string,palabra:string){
    this.loader = true;
    const url = this.servidor+'shop/traer-articulos-like-que.php?tabla='+tabla+'&palabra='+palabra+'&que='+que;  // URL to web api
    return this.http.get<any>(url)
    .pipe(
      catchError(this.handleError),
      tap((data)=>{
        //console.log(data);
        this.loader = false;})
    );
  }

  busqueda(tabla:string, data:any):Observable<any[]>{
   // console.log(tabla, data);
    const url = this.servidor+'shop/buscar-en-todas-las-columnas.php'; // URL to web api
    //console.log(url);
    const options = new HttpParams()
      .set('tabla', tabla)
      .set('data',data)
    ;
    return this.http.post<any[]>(url,options)
    .pipe(
      tap(data=>{
        //this.options.next(data);
        //console.log(data);
      }),
      map(resp=>{
        return resp;
      }),
      debounceTime(500),
      distinctUntilChanged(),
      startWith([]),
      catchError(this.handleError),
    );
  };
  traerNovedadesSeo(seo:string):Observable<any[]>{
    const url = this.servidor+'traer-novedades-por-seo.php?seo='+seo;  // URL to web api
    return this.http.get<any[]>(url)
    .pipe(
      tap(data=>{
        //this.options.next(data);
        //console.log(data);
      }),
      map(resp=>{
        return resp;
      }),
      debounceTime(500),
      distinctUntilChanged(),
      startWith([]),
      catchError(this.handleError),
    );
  }

  buscarSuscriptores(tabla:string, email:string):Observable<number>{
    const url = this.servidor+'buscar-suscriptores.php';  // URL to web api
    const options = new HttpParams()
      .set('tabla', tabla)
      .set('email',email)
    ;
    return this.http.post<number>(url,options)
    .pipe(
      tap(data=>{
        //this.options.next(data);
        //console.log(data);
      }),
      map(resp=>{
        return resp;
      }),
      debounceTime(500),
      distinctUntilChanged(),
      catchError(this.handleError),
    );
  }

  blog_next(id:string):Observable<any>{
    //console.log(id);
    const url = this.servidor+'blog-next.php?id='+id; 
    return this.http.get<any>(url)
    .pipe(
      tap(data=>{
        //console.log(data);
      }),
      map(resp=>{
        return resp;
      }),
      debounceTime(500),
      distinctUntilChanged(),
      startWith([]),
      catchError(this.handleError),
    );
  }

  blog_prev(id:string):Observable<any>{
    //console.log(id);
    const url = this.servidor+'blog-prev.php?id='+id; 
    return this.http.get<any>(url)
    .pipe(
      tap(data=>{
        //console.log(data);
      }),
      map(resp=>{
        return resp;
      }),
      debounceTime(500),
      distinctUntilChanged(),
      startWith([]),
      catchError(this.handleError),
    );
  }

  traerBlog():Observable<any[]>{
    this.loader = true;
    const url = this.servidor+'traer-blog.php';  // URL to web api
    return this.http.get<any[]>(url)
    .pipe(
      tap(data=>{
        console.log(data);
      }),
      map(resp=>{
        return resp;
      }),
      debounceTime(500),
      distinctUntilChanged(),
      startWith([]),
      catchError(this.handleError),
    );
  }
 
}
