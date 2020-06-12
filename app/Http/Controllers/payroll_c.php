<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\payroll;
use App\bpjs_kesehatan as bks;
use App\bpjs_ketenagakerjaan as bkt;
use App\pph_ptkp as ptkp;
use App\pph_pkp as pkp;

class payroll_c extends Controller
{
  function payroll(Request $data){
    $page = payroll::orderBy('updated_at', 'Desc');
    if ($data->q) { $page->where('name', 'like', '%'.$data->q.'%'); }
    $page = $page->paginate(5);
    $payroll = $page->map(function($i){
      return $i;
    });
    return compact('payroll', 'page');
  }
  function detail($payroll_id){
    $payroll = payroll::where('payroll_id', $payroll_id)->first();
    return compact('payroll');
  }
  function store(Request $data){
    $payroll_id = payroll::max('payroll_id')+1;
    $payroll = new payroll;
    $payroll->payroll_id = $payroll_id;
    $payroll->all_jabatan = $data->all_jabatan;
    if ($data->all_jabatan != 1) {
      $payroll->jabatan_id = implode($data->jabatan_id, '|');
    }
    $payroll->name = $data->name;
    $payroll->type = $data->type;
    $payroll->percent = $data->percent;
    $payroll->value = $data->value;
    $payroll->desc = $data->desc;
    $payroll->save();
    return $payroll;
  }
  function update(Request $data){
    $payroll = payroll::where('payroll_id', $data->payroll_id)->first();
    $payroll->all_jabatan = $data->all_jabatan;
    if ($data->all_jabatan != 1) {
      $payroll->jabatan_id = implode($data->jabatan_id, '|');
    }
    if ($data->name) { $payroll->name = $data->name; }
    $payroll->type = $data->type;
    $payroll->percent = $data->percent;
    if ($data->value) { $payroll->value = $data->value; }
    if ($data->desc) { $payroll->desc = $data->desc; }
    $payroll->save();
    return $payroll;
  }
  function bpjs_kesehatan(Request $data){
    return bks::first() ?? [];
  }
  function bpjs_kesehatan_update(Request $data){
    $bks = bks::first() ?? new bks;
    $bks->company = $data->company;
    $bks->employee = $data->employee;
    $bks->min = $data->min;
    $bks->max = $data->max;
    $bks->save();
    return $bks;
  }
  function bpjs_ketenagakerjaan(Request $data){
    return bkt::first() ?? [];
  }
  function bpjs_ketenagakerjaan_update(Request $data){
    $bks = bkt::first() ?? new bkt;
    $bks->jht_company = $data->jht_company;
    $bks->jht_employee = $data->jht_employee;
    $bks->jht_min = $data->jht_min;
    $bks->jht_max = $data->jht_max;
    $bks->jkk_company = $data->jkk_company;
    $bks->jkk_employee = $data->jkk_employee;
    $bks->jkk_min = $data->jkk_min;
    $bks->jkk_max = $data->jkk_max;
    $bks->jkm_company = $data->jkm_company;
    $bks->jkm_employee = $data->jkm_employee;
    $bks->jkm_min = $data->jkm_min;
    $bks->jkm_max = $data->jkm_max;
    $bks->jp_company = $data->jp_company;
    $bks->jp_employee = $data->jp_employee;
    $bks->jp_min = $data->jp_min;
    $bks->jp_max = $data->jp_max;
    if (count($data->all())) { $bks->save(); }
    return $bks;
  }
  function pph_ptkp(Request $data){
    return ptkp::first() ?? [];
  }
  function pph_ptkp_update(Request $data){
    $ptkp = ptkp::first() ?? new ptkp;
    $ptkp->tk = $data->tk;
    $ptkp->k = $data->k;
    $ptkp->ki = $data->ki;
    $ptkp->tanggungan = $data->tanggungan;
    $ptkp->max = $data->max;
    $ptkp->save();
    return $ptkp;
  }
  function pph_pkp(Request $data){
    return pkp::get() ?? [];
  }
  function pph_pkp_update(Request $data){
    if (count($data->pkp)) {
      pkp::truncate();
      foreach ($data->pkp as $pkp) {
        pkp::create(['nominal' => $pkp['nominal'], 'pajak' => $pkp['pajak']]);
      }
      return pkp::get();
    }
  }
}
