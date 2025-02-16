import { Component } from '@angular/core';
import {BenchResultsService} from '../../services/bench-results.service';
import {Bench} from '../../models/bench';
import {CommonModule} from '@angular/common';
import {FormsModule, NgForm} from '@angular/forms';
import {Router} from '@angular/router';
import {AuthService} from '../../services/auth.service';

@Component({
  selector: 'app-upload-result',
  imports: [CommonModule, FormsModule],
  templateUrl: './upload-result.component.html',
  styleUrl: './upload-result.component.css'
})
export class UploadResultComponent {

  public status:number|null = 0;
  public message:string|null = "";
  public username:string = "";
  public bench_name:string|null = "";
  public bench_type:string|null = "";
  public model:string|null = "";
  public frequency:number|null = null;
  public average:number|null = null;
  public fastest:number|null = null;

  constructor(private auth:AuthService, private benchService:BenchResultsService, private router:Router) {
    let token = localStorage.getItem('token');
    if (token != null) {
      this.auth.authorize(token).subscribe({
        next:(data)=>{
          this.status = data.status;
          this.username = data.data.name;
        },
        error:(error)=>{
          this.status = error.status;
          this.message = error.error.error;
        }
      })
    } else {
      this.auth.authorize("").subscribe({
        error:(error)=>{
          this.status = error.status;
          this.message = error.statusText;
        }
      })
    }
  }

  public addNewResult(f:NgForm){
    const tmp:Bench={
      username:this.username,
      bench_name:f.form.value.bench_name,
      bench_type:f.form.value.bench_type,
      hw_model:f.form.value.model,
      frequency:f.form.value.frequency,
      average:f.form.value.average,
      fastest:f.form.value.fastest,
      id:null,
      status:null,
      message:null
    };
    console.log(tmp);

    this.benchService.addResult(tmp).subscribe({
      next:(data)=>{
        console.log(data);
        this.router.navigate(["benchmarks/"+this.bench_name]);
      },
      error:(error)=>{
        console.log(error);
      }
    });
  }
}
