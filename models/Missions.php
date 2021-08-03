<?php

namespace app\models;

use Yii;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Missions extends \yii\db\ActiveRecord {

  // public $approvepostfio  //Runtime property in gridview

  public static function tableName()    {
    return 'missions';
  }

  public function rules()    {
    return [
        [['mission_name', 'mission_date', 'approve_post', 'approve_fio'], 'required'],
        [['mission_date', 'created', 'changed'], 'safe'],
        [['status'], 'integer'],
        [['mission_name'], 'string', 'max' => 256],
        [['description', 'approve_post', 'approve_fio'], 'string', 'max' => 100],
        [['url'], 'string', 'max' => 2048],
        [['mission_name'], 'unique'],
    ];
  }

  public function attributeLabels()    {
    return [
      'uid' => 'Код',
      'mission_name' => 'Наименование',
      'mission_date' => 'Дата создания',
      'description' => 'Описание',
      'status' => 'Состояние',
      'approve_post' => 'Должность утверждающего',
      'approve_fio' => 'Ф.И.О. утверждающего',
      'url' => 'URL Ссылка',
      'created' => 'Дата создания',
      'changed' => 'Дата изменения',
    ];
  }

  public function getMissionitems()    {
    return $this->hasMany(Missionitems::className(), ['missionuid' => 'uid']);
  }

  public static function find()  {
      return new MissionsQuery(get_called_class());
  }

  //формирует массив сотсояний поручений
  public static function statesDropdown(){
    return [
      STATE_ASSIGN  =>'Формирование',
      STATE_REPORT  =>'Отчетность',
      STATE_CLOSED  =>'Закрыто',
      STATE_DELETED =>'Удалено',
    ];
  }

  //возвращает наименование состояния поручения из массива по ИД
  public static function stateName($id){
    $arr  = self::statesDropdown();
    return (array_key_exists($id,$arr)) ? $arr[$id] : '';
  }

  //Простой массив наименований состояний
  public static function stateNames(){
    // $arr = array("Открыто","Закрыто");
    return array_values(self::statesDropdown());
    // return $arr;
  }

  //Возвращает текущее состояние поручений
  public static function getMissionstate($id){
      return self::findOne($id)->status;
  }

  //Экспот в Excel display instead of download
  public static function export($id,$executerid=null,$assignerid=null){
      $model = Self::findOne($id);
      if ($model !== null){
        $template = './templates/MissionsTemplate1.xltx';
        $file = 'MissionsReport.xlsx';
        $row = 7;
        $num = 1;
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($template);
        $sheet = $spreadsheet->getActiveSheet();
        //Заполнение шапки шаблона
        $sheet->setCellValue('E2', $model->approve_post . "\n". '___________ '.$model->approve_fio);
        $sheet->setCellValue('A4', $model->mission_name);
        //Заполнение деталей
        $where = ['missionuid'=>$id];
        if ($executerid !== null) $missionItems[] = ['executeruid'=>$executerid];
        if ($assignerid !== null) $missionItems[] = ['assigneruid'=>$assignerid];
        // $missionItems = Missionitems::find()->where($where)->orderBy(['executeruid'=>SORT_ASC,'assigneruid'=>SORT_ASC,'uid'=>SORT_ASC])->all();
        $missionItems = Missionitems::find()->joinWith(['assigner a'])->where($where)->orderBy(['executeruid'=>SORT_ASC,'a.ordernumber'=>SORT_ASC,'uid'=>SORT_ASC])->all();
        $lastexecuter = null;
        $lastassigner = null;
        if ($missionItems !== null){
          foreach ($missionItems as $item) {
            if ($lastexecuter !== $item->executeruid){
              $sheet->setCellValue('A'.$row, 'Поручения для '.$item->executer->name);
              $sheet->mergeCells('A'.$row.':'.'F'.$row);
              $sheet->getStyle('A'.$row.':'.'F'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
              $sheet->getStyle('A'.$row.':'.'F'.$row)->getFont()->setBold(true);
              $num = 1;
              $row = $row + 1;
              $lastexecuter = $item->executeruid;
            }
            if ($lastassigner !== $item->assigneruid){
              // $sheet->setCellValue('A'.$row, 'От '.$item->assigner->name);
              $sheet->setCellValue('A'.$row, $item->assigner->ordernumber.'. '.$item->assigner->name);
              $sheet->mergeCells('A'.$row.':'.'F'.$row);
              $sheet->getStyle('A'.$row.':'.'F'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
              $sheet->getStyle('A'.$row.':'.'F'.$row)->getFont()->setBold(true);
              $row = $row + 1;
              $lastassigner = $item->assigneruid;
            }
            $sheet->setCellValue('A'.$row, $num);
            $sheet->setCellValue('B'.$row, $item->task);
            $sheet->setCellValue('C'.$row, $item->deadline);
            $sheet->setCellValue('D'.$row, $item->report);
            $sheet->setCellValue('E'.$row, $item->executer_name);
            $sheet->setCellValue('F'.$row, $item->assigner_name);
            $sheet->getStyle('A'.$row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('B'.$row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('C'.$row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('D'.$row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('E'.$row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('F'.$row)->getAlignment()->setWrapText(true);
            $num = $num + 1;
            $row = $row + 1;
          }
        }

        //Сохранение и загрузка
        $writer = new Xlsx($spreadsheet);
        $writer->save($file);


        if (file_exists($file)) {
          // ob_clean();
          header('Content-Description: File Transfer');
          header('Content-Type: application/octet-stream');
          header('Content-Disposition: attachment; filename=' . basename($file));
          header('Content-Transfer-Encoding: binary');
          header('Expires: 0');
          header('Cache-Control: must-revalidate');
          header('Pragma: public');
          header('Content-Length: ' . filesize($file));
          readfile($file);
          // flush();
          unlink($file);
          exit;
        }

        // History::log('Поручения с кодом '.$id.' выгружены в MS Excel');
      }else{
        throw new NotFoundHttpException('Не найдена запись поручений');
      }
  }

  //Возвращает текущее состояние поручений
  // public static function copy($id){
  //     return self::findOne($id)->status;
  // }

  // public static function monthsDropdown(){
  //   $arr = [
  //     1=>'январь',
  //     2=>'февраль',
  //     3=>'март',
  //     4=>'апрель',
  //     5=>'май',
  //     6=>'июнь',
  //     7=>'июль',
  //     8=>'август',
  //     9=>'сентябрь',
  //     10=>'октябрь',
  //     11=>'ноябрь',
  //     12=>'декабрь'
  //   ];
  //   return $arr;
  // }

}
