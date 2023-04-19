<?php

namespace app\components\services;

use app\models\User;
use Exception;
use Yii;


/**
 * This class is used for User services which read, create and update user data
 */
class UserService
{
    /**
     * Return records without manipulated attributes
     *
     * @param array $params
     * @return array
     */
    public function getUsers(array $params = []): array
    {
        $data = User::find()->limit($params['limit'])->asArray()->all();
        if (!empty($data)) {
            $response = [
                'message' => 'Users List',
                'status' => 'Success',
                'data' => $data
            ];
        } else {
            $response = [
                'message' => 'No data found',
                'status' => 'Success',
                'data' => $data
            ];

        }
        return $response;
    }

    /**
     * Return records with manipulated attributes
     *
     * @param array $params
     * @return array
     */
    public function getUsersManipulated(array $params = []): array
    {
        $users = User::find()->limit($params['limit'])->asArray()->all();
        foreach ($users as $key=>$user) {
            $users[$key] = $this->getChangedValues($user);
        }
        if (!empty($users)) {
            $response = [
                'message' => 'Users List',
                'status' => 'Success',
                'data' => $users
            ];
        } else {
            $response = [
                'message' => 'No data found',
                'status' => 'Success',
                'data' => $users
            ];

        }
        return $response;
    }

    /**
     * Change values (manipulate string and number)
     *
     * @param array $user
     * @return array
     */
    private function getChangedValues(array $user): array
    {
        $user['first_name'] = strtoupper($user['first_name']);
        $user['last_name'] = strtoupper($user['last_name']);
        $user['age'] += 1;
        return $user;
    }

    /**
     * Create users
     *
     * @param array $data
     * @return array
     * @throws \yii\db\Exception
     */
    public function createUsers(array $data = []): array
    {
        $users = [];
        $columns = ['first_name', 'last_name', 'email', 'age', 'password'];
        foreach ($data as $user) {
            $users[] = [$user['first_name'], $user['last_name'], $user['email'], $user['age'], $user['password']];
        }
        $rows = Yii::$app->db->createCommand()->batchInsert(User::tableName(), $columns, $users)->execute();

        if (count($rows)) {
            $response = [
                'message' => "Users created",
                'status' => 'Success',
                'data' => count($rows)
            ];
        } else {
            $response = [
                'message' => 'No data processed',
                'status' => 'Success',
                'data' => count($rows)
            ];

        }
        return $response;
    }

    /**
     * Update users
     *
     * @param array $data
     * @return array
     */
    public function updateUsers(array $data = []): array
    {
        $updated = 0;
        foreach ($data as $user) {
            if (isset($user['id'])) {
                $existingUser = User::find()->where('id=:id', [':id' => $user['id']])->one();
                if (!empty($existingUser)) {
                    $existingUser['first_name'] = $user['first_name'];
                    $existingUser['last_name'] = $user['last_name'];
                    $existingUser['email'] = $user['email'];
                    $existingUser['age'] = $user['age'];
                    if ($existingUser->save()) {
                        $updated++;
                    }
                }
            }
        }

        //return number of updated users
        if ($updated) {
            $response = [
                'message' => 'Users Updated',
                'status' => 'Success',
                'data' => $updated
            ];
        } else {
            $response = [
                'message' => 'No Users Updated',
                'status' => 'Success',
                'data' => $updated
            ];

        }
        return $response;
    }
}
