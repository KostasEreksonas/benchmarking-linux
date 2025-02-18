import { Component } from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {BenchResultsService} from '../../services/bench-results.service';
import {CommonModule} from '@angular/common';
import {FormsModule, NgForm} from '@angular/forms';

@Component({
  selector: 'app-edit-result',
  imports: [CommonModule, FormsModule],
  templateUrl: './edit-result.component.html',
  styleUrl: './edit-result.component.css'
})
export class EditResultComponent {
  public id:string;
  public benchmark:string;
  public username:string = "";
  public bench_name:string = "";
  public bench_type:string|null = "";
  public model:string|null = "";
  public frequency:number|null = null;
  public average:number|null = null;
  public fastest:number|null = null;
  public err_status:number = 0;
  public err_msg:string|null = '';

  constructor(private route:ActivatedRoute, private router:Router, private benchService:BenchResultsService) {
    this.id = this.route.snapshot.params["id"];
    this.benchmark = this.route.snapshot.params["benchmark"];
    this.benchService.loadResult(this.benchmark, this.id).subscribe({
    next:(data)=>{
      this.username = data[0].username;
      this.bench_name = data[0].bench_name;
      this.bench_type = data[0].bench_type;
      this.model = data[0].hw_model;
      this.frequency = data[0].frequency;
      this.average = data[0].average;
      this.fastest = data[0].fastest;
    },
    error:(error)=>{
      this.err_status = error.status;
      this.err_msg = error.statusText;
    }
    })
  }

  public updateRecord(f:NgForm){
    this.benchService.updateRecord({
      id:this.id,
      username:this.username,
      bench_name:this.bench_name,
      bench_type:f.form.value.bench_type,
      hw_model:f.form.value.model,
      frequency:f.form.value.frequency,
      average:f.form.value.average,
      fastest:f.form.value.fastest,
      status:null,
      message:null
    }).subscribe({
      next:()=>{
        this.router.navigate(["profile/"+this.username]);
      },
      error:(error)=>{
        this.err_status = error.status;
        this.err_msg = error.statusText;
      }
    })
  }
}
