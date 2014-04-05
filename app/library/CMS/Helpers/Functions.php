<?php namespace CMS\Helpers;

class Functions {

    /**
     * Test
     *
     * @param string  $value
     * @return string
     */
    public static function mimic($value)
    {
        return $value;
    }

    /**
     * Processes bulk list actions (e.g. delete, archive, activate, inactivate)
     * @param  array|var $ids
     * @param  string $action
     * @return integer|bool
     */
    public static function bulkProcess($model, $ids, $action)
    {
        if (!empty($ids) && $action) {

            $recs = $model->whereIn('id', $ids)->get(); // get models

            foreach($recs AS $rec)
            {
                switch($action) {

                    case 'soft delete' : $rec->delete(); break;
                    case 'delete'      : $rec->forceDelete(); break;
                    case 'archive'     : $rec->status = 2; $rec->save(); break;
                    case 'activate'    :
                        if ($model->getTable() == 'users') { 
                            $rec->confirmed = 1;
                            $rec->updateUniques(); // Ardent
                        } else {
                            $rec->status = 1;
                            $rec->save();
                        } break;
                    case 'inactivate'  :
                        if ($model->getTable() == 'users') { 
                                $rec->confirmed = 0;
                                $rec->updateUniques(); // Ardent
                            } else {
                                $rec->status = 0;
                                $rec->save();
                            } break;
                    default: return false;
                }
            }

            return count($recs);
        }

        return false;
    }


}