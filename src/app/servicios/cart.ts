import { FormControl } from "@angular/forms";

export interface Cart {
    id:string;
    img:string;
    nombre:string;
    precio: number;
    cantidad:any;
    color:string;
    colorIndex:number;
    stock:any;
    unidades:string;
}
