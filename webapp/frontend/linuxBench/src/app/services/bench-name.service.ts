import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class BenchNameService {
  public benchName:string = "";

  constructor() { }
}
