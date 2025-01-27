import { Injectable } from '@angular/core';
import { Cart } from './cart';
import {MatSnackBar} from '@angular/material/snack-bar';

@Injectable({
  providedIn: 'root'
})
export class CartService {

  constructor( 
    private _snackBar: MatSnackBar
  ) {
    this.carrito = this.traerCarritoDelStorage();
  }
  public showCarrito:boolean = false;
  public carrito: Cart[] = [];
  public cantidad_de_productos_pedidos:number = 0;
  public precio_total:number = 0;
  public carritoStorage:any = "";
  
  public openSnackBar(message: string, action: string) {
    this._snackBar.open(message, action,{duration: 2000});
  }
  
  public guardarCarritoStorage(){
    localStorage.setItem('carrito', JSON.stringify(this.carrito));
  }

  public traerCarritoDelStorage(){
    this.carritoStorage = localStorage.getItem('carrito');
    console.log(JSON.parse(this.carritoStorage));
    return JSON.parse(this.carritoStorage);
  }

  public addCart(cartObj:Cart){
    
    if(this.carrito === null){
      //console.log("El carrito esta vacio, dejo entrar el objeto");
      this.carrito = [];
      this.carrito.push(cartObj);
      this.openSnackBar('elemento sumado al carro de compras','ok');
    }else{
      
      if((this.carrito.find(e => e.id === cartObj.id))&&(this.carrito.find(e => e.color === cartObj.color))){
        for(let x in this.carrito){
          if(this.carrito[x].id  === cartObj.id){
            if(this.carrito[x].color === cartObj.color){
              this.SumarCarrito(x,cartObj.cantidad);
              //console.log("MISMO PRODUCTO Y MISMO COLOR");
              //console.log(this.carrito); 
              
              return;
            }
          }
        }
      }
      if((this.carrito.find(e => e.id === cartObj.id))&&(!this.carrito.find(e => e.color === cartObj.color))){
        for(let x in this.carrito){
          if(this.carrito[x].id  === cartObj.id){
            if(this.carrito[x].color !== cartObj.color){
              this.carrito.push(cartObj);
              //console.log("MISMO PRODUCTO Y DISTINTO COLOR");
              //console.log(this.carrito); 
              this.openSnackBar('elemento sumado al carro de compras','ok');
              return;
            }
          }
        }
      }
      if(!this.carrito.find(e => e.id === cartObj.id)){
        //console.log("NO HAY UN ID IGUAL EN EL CARRITO");
        this.openSnackBar('elemento sumado al carro de compras','ok');
        this.carrito.push(cartObj);
      }   
    }
    this.guardarCarritoStorage();
    this.carrito = this.traerCarritoDelStorage();
    //console.log(this.carrito); 
  } 

 /*public controlStock(id:any){
    if(Number(this.carrito[id].stock) === -1){
      this.openSnackBar('Disculpas, solo puedes comprar '+this.carrito[id].cantidad ,'ok');
      return;
    }
  }*/


  public SumarCarrito(id:any,cantidad:number){
    if(this.carrito !==null){
      if(Number(this.carrito[id].stock)!==0){
        //console.log('es distinto a cero');
        this.carrito[id].cantidad += cantidad;
        this.carrito[id].stock -= cantidad;
        this.guardarCarritoStorage();
        this.openSnackBar('Artículo sumado al carrito de compras','ok');
        
      }
      if(Number(this.carrito[id].stock)===0){
        //console.log('es igual a cero');
        this.openSnackBar('Disculpas, solo puedes comprar '+this.carrito[id].cantidad ,'ok');
        return;
      }
    }
    
  }
  

  public BorrarCarrito(id:any){
    if(this.carrito !==null){
      this.carrito.splice(id,1);
      
      this.guardarCarritoStorage();
      this.openSnackBar('Artículo eliminado del carrito de compras','ok');
    }
  }

  public RestarCarrito(id:any,cantidad:number){
    if(this.carrito !==null){
      if(this.carrito[id].cantidad===0){
        return;
      }else{
        this.carrito[id].cantidad -= cantidad;
        this.carrito[id].stock += cantidad; 
      }
      this.guardarCarritoStorage();
      this.openSnackBar('Artículo restado del carrito de compras','ok');
    }
  }

  sumarCantidades(){
    this.cantidad_de_productos_pedidos = 0;
    for(let x in this.carrito){
      this.cantidad_de_productos_pedidos += this.carrito[x].cantidad; 
    }
    return this.cantidad_de_productos_pedidos;
  }
  sumarPrecios(){
    this.precio_total = 0;
    for(let x in this.carrito){
      this.precio_total += this.carrito[x].precio * this.carrito[x].cantidad; 
    }
    return this.precio_total;
  }
}
