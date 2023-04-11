<?php
namespace App\Traits\Model;
use DB;
use Carbon\Carbon;

trait TableMaint
{

    public function getUtilities(): array
    {
        return $this->utilities;
    }

    public function getActions(): array
    {
        return $this->actions;
    }

    public function hydrateForm(?string $formname = null): array
    {
        // use defined default form is not passed in.
        if (is_null($formname)) {
            $form = $this->form;
        } else {
            $form = $this->$formname;
        }
        foreach($form as $rowIndex => $row) {
            foreach($row as $elementIndex => $element) {
                $datapoint = $element['parameters']['datapoint'];
                if(isset($this->$datapoint)) {
                    if($element['type'] == 'input_date') {
                        $form[$rowIndex][$elementIndex]['parameters']['value'] =
                            Carbon::parse($this->$datapoint)->format('Y-m-d');

                    } else {
                        $form[$rowIndex][$elementIndex]['parameters']['value'] =
                            $this->$datapoint;
                    }
                }
            }
        }
        return $form;
    }

}
